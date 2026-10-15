<?php
/**
 * Carregado por todas as páginas e pelo enviar.php.
 * Compatível com PHP 7.4+ (versões oferecidas pela HostGator).
 */

define('APP_DIR', __DIR__);
define('ROOT_DIR', dirname(__DIR__));

date_default_timezone_set('America/Sao_Paulo');

/**
 * Lê um arquivo .env simples (CHAVE=valor, linhas com # são comentários).
 * Procura primeiro um nível acima da raiz do site (fora do public_html),
 * depois na própria raiz.
 */
function load_env()
{
    foreach ([dirname(ROOT_DIR) . '/.env', ROOT_DIR . '/.env'] as $file) {
        if (!is_readable($file)) {
            continue;
        }
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
                continue;
            }
            list($key, $value) = array_map('trim', explode('=', $line, 2));
            if (strlen($value) > 1 && ($value[0] === '"' || $value[0] === "'") && substr($value, -1) === $value[0]) {
                $value = substr($value, 1, -1);
            }
            if (getenv($key) === false) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
        return;
    }
}
load_env();

function env($key, $default = '')
{
    $value = getenv($key);
    return ($value === false || $value === '') ? $default : $value;
}

function config($key = null)
{
    static $config = null;
    if ($config === null) {
        $config = require APP_DIR . '/config.php';
    }
    if ($key === null) {
        return $config;
    }
    $value = $config;
    foreach (explode('.', $key) as $part) {
        $value = isset($value[$part]) ? $value[$part] : null;
    }
    return $value;
}

/** Escapa texto para HTML. */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** URL de um arquivo em /assets com ?v= para invalidar o cache quando ele muda. */
function asset($path)
{
    $file = ROOT_DIR . '/assets/' . $path;
    $version = is_file($file) ? filemtime($file) : '';
    return '/assets/' . $path . ($version ? '?v=' . $version : '');
}

/** URL absoluta (canonical, Open Graph). */
function absolute_url($path)
{
    return rtrim(env('SITE_URL', 'https://www.spectrumbh.com.br'), '/') . $path;
}

/**
 * Atributos de um botão cujo destino é configurado em config.php → links.
 * Enquanto o valor for 'PENDENTE', o botão mostra o aviso do protótipo.
 */
function link_attrs($key)
{
    $link = config('links.' . $key);
    if (empty($link['url']) || $link['url'] === 'PENDENTE') {
        return 'href="#" data-link-pendente="' . e($link['aviso']) . '"';
    }
    return 'href="' . e($link['url']) . '" target="_blank" rel="noopener"';
}

/** Token com a hora em que o formulário foi exibido (usado contra robôs). */
function form_token()
{
    $time = (string) time();
    return $time . '.' . hash_hmac('sha256', $time, app_secret());
}

function app_secret()
{
    return env('APP_SECRET', hash('sha256', ROOT_DIR . env('SMTP_PASS')));
}

/**
 * Campos ocultos comuns a todos os formulários: identificação do formulário,
 * token de tempo e o campo-armadilha (honeypot) que pessoas não preenchem.
 */
function form_hidden_fields($formKey)
{
    return '<input type="hidden" name="_form" value="' . e($formKey) . '">'
        . '<input type="hidden" name="_t" value="' . e(form_token()) . '">'
        . '<div class="hp-field" aria-hidden="true"><label for="hp-' . e($formKey) . '">Não preencha este campo</label>'
        . '<input type="text" id="hp-' . e($formKey) . '" name="website" tabindex="-1" autocomplete="off"></div>';
}

/** Widget do Cloudflare Turnstile (somente se as chaves estiverem no .env). */
function turnstile_widget()
{
    $siteKey = env('TURNSTILE_SITE_KEY');
    if (!$siteKey) {
        return '';
    }
    return '<div class="cf-turnstile" data-sitekey="' . e($siteKey) . '" data-appearance="interaction-only" data-language="pt-br"></div>';
}

/**
 * Estado do formulário depois de um envio sem JavaScript
 * (enviar.php redireciona de volta com ?enviado= ou ?erro=).
 * Retorna as classes CSS e a mensagem de erro, se houver.
 */
function form_state($formKey)
{
    $classes = '';
    $message = '';
    if (isset($_GET['enviado']) && $_GET['enviado'] === $formKey) {
        $classes = ' submitted';
    } elseif (isset($_GET['erro']) && $_GET['erro'] === $formKey) {
        $classes = ' has-error';
        $code = isset($_GET['motivo']) ? $_GET['motivo'] : '';
        $messages = config('mensagens_erro');
        $message = isset($messages[$code]) ? $messages[$code] : '';
    }
    return [$classes, $message];
}

function default_error_message()
{
    return config('mensagens_erro.envio');
}
