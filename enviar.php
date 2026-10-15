<?php
/**
 * Recebe todos os formulários do site e envia por e-mail.
 *
 * - Com JavaScript: o site.js envia via fetch e recebe JSON {ok, message}.
 * - Sem JavaScript: POST normal; responde com redirecionamento para a página
 *   do formulário (?enviado=... ou ?erro=...).
 *
 * Destinatários e campos ficam em app/config.php → forms (nunca vêm do navegador).
 */
require __DIR__ . '/app/bootstrap.php';
require APP_DIR . '/mailer.php';

$wantsJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
$forms = config('forms');
$formKey = isset($_POST['_form']) && is_string($_POST['_form']) ? $_POST['_form'] : '';
$form = isset($forms[$formKey]) ? $forms[$formKey] : null;

/** Encerra a requisição com sucesso ou erro, no formato adequado. */
function respond($ok, $code = null)
{
    global $wantsJson, $form, $formKey;
    $message = $ok ? '' : config('mensagens_erro.' . $code);
    if ($wantsJson) {
        http_response_code($ok ? 200 : ($code === 'envio' ? 500 : 422));
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if (!$form) {
        header('Location: /', true, 303);
        exit;
    }
    $query = $ok ? 'enviado=' . rawurlencode($formKey)
                 : 'erro=' . rawurlencode($formKey) . '&motivo=' . rawurlencode($code);
    header('Location: ' . $form['pagina'] . '?' . $query . '#' . $form['ancora'], true, 303);
    exit;
}

function log_error($message)
{
    @file_put_contents(
        APP_DIR . '/storage/erros.log',
        '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n",
        FILE_APPEND | LOCK_EX
    );
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /', true, 303);
    exit;
}
if (!$form) {
    respond(false, 'validacao');
}

// ---- 1. Honeypot: campo invisível que só robôs preenchem. Finge sucesso. ----
if (!empty($_POST['website'])) {
    respond(true);
}

// ---- 2. Tempo de preenchimento: token assinado com a hora em que a página abriu ----
$token = isset($_POST['_t']) && is_string($_POST['_t']) ? $_POST['_t'] : '';
$parts = explode('.', $token, 2);
if (count($parts) !== 2 || !hash_equals(hash_hmac('sha256', $parts[0], app_secret()), $parts[1])) {
    respond(false, 'verificacao');
}
$elapsed = time() - (int) $parts[0];
if ($elapsed < 2) {
    respond(true); // rápido demais para uma pessoa: descarta em silêncio
}
if ($elapsed > 86400) {
    respond(false, 'verificacao'); // página aberta há mais de 24 h
}

// ---- 3. Limite de envios por IP (5 a cada 10 minutos) ----
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0';
if (!rate_limit_ok($ip, 5, 600)) {
    respond(false, 'limite');
}

// ---- 4. Cloudflare Turnstile (somente se configurado no .env) ----
if (env('TURNSTILE_SECRET_KEY')) {
    $response = isset($_POST['cf-turnstile-response']) ? (string) $_POST['cf-turnstile-response'] : '';
    if ($response === '' || !turnstile_ok($response, $ip)) {
        respond(false, 'verificacao');
    }
}

// ---- 5. Validação dos campos ----
$rows = [];
$replyTo = null;
foreach ($form['campos'] as $name => $def) {
    list($label, $required, $type) = $def;
    $options = isset($def[3]) ? $def[3] : [];
    $raw = isset($_POST[$name]) ? $_POST[$name] : '';

    if ($type === 'lista') {
        $values = is_array($raw) ? array_values(array_intersect($options, array_map('strval', $raw))) : [];
        if ($required && !$values) {
            respond(false, 'validacao');
        }
        $rows[$label] = implode(', ', $values);
        continue;
    }

    $value = is_string($raw) ? clean_text($raw, $type === 'textarea' ? 5000 : 200) : '';
    if ($required && $value === '') {
        respond(false, 'validacao');
    }
    if ($value !== '' && $type === 'email') {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            respond(false, 'validacao');
        }
        $replyTo = $value;
    }
    if ($value !== '' && $type === 'opcao' && !in_array($value, $options, true)) {
        respond(false, 'validacao');
    }
    $rows[$label] = $value;
}

// ---- 6. Envio ----
$nome = isset($rows[$form['campos']['nome'][0]]) ? $rows[$form['campos']['nome'][0]] : '';
$subject = '[Site Spectrum] ' . $form['nome'] . ($nome !== '' ? ' — ' . $nome : '');
list($html, $text) = build_mail_body($form['nome'], $rows, $form['pagina']);

try {
    send_mail($form['para'], $subject, $html, $text, $replyTo);
} catch (Exception $ex) {
    log_error('Falha ao enviar "' . $formKey . '": ' . $ex->getMessage());
    respond(false, 'envio');
}

respond(true);


// ---------------------------------------------------------------------------

/** Remove caracteres de controle (mantém quebras de linha) e limita o tamanho. */
function clean_text($value, $max)
{
    $value = preg_replace('/[^\P{C}\n\t]/u', '', str_replace("\r\n", "\n", $value));
    $value = trim((string) $value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max, 'UTF-8') : substr($value, 0, $max);
}

function rate_limit_ok($ip, $max, $window)
{
    $file = APP_DIR . '/storage/limite-envios.json';
    $fp = @fopen($file, 'c+');
    if (!$fp) {
        return true; // sem armazenamento disponível, não bloqueia
    }
    flock($fp, LOCK_EX);
    $data = json_decode(stream_get_contents($fp), true);
    $data = is_array($data) ? $data : [];
    $now = time();
    $key = hash('sha256', $ip); // não guarda o IP em texto
    foreach ($data as $k => $times) {
        $data[$k] = array_values(array_filter($times, function ($t) use ($now, $window) {
            return $t > $now - $window;
        }));
        if (!$data[$k]) {
            unset($data[$k]);
        }
    }
    $ok = !isset($data[$key]) || count($data[$key]) < $max;
    if ($ok) {
        $data[$key][] = $now;
    }
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($data));
    flock($fp, LOCK_UN);
    fclose($fp);
    return $ok;
}

function turnstile_ok($response, $ip)
{
    $payload = http_build_query([
        'secret'   => env('TURNSTILE_SECRET_KEY'),
        'response' => $response,
        'remoteip' => $ip,
    ]);
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);
        $body = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
    } else {
        $error = '';
        $body = @file_get_contents($url, false, stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $payload,
            'timeout' => 10,
        ]]));
    }
    $result = $body ? json_decode($body, true) : null;
    if (!is_array($result)) {
        log_error('Turnstile: sem resposta da Cloudflare' . ($error ? ' (' . $error . ')' : ''));
        return false;
    }
    return !empty($result['success']);
}
