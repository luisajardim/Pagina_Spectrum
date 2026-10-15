<?php
/**
 * Roteador para o servidor embutido do PHP (somente desenvolvimento local):
 *
 *     php -S localhost:8000 router.php
 *
 * Reproduz o que o .htaccess faz na hospedagem: entrega arquivos estáticos,
 * bloqueia arquivos internos e manda o resto para o index.php.
 */
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (preg_match('#^/(app|\.env|\.git|router\.php|README\.md|spectrumprototipo)#', $path)) {
    http_response_code(403);
    echo 'Acesso negado.';
    return true;
}

if ($path === '/enviar.php') {
    require __DIR__ . '/enviar.php';
    return true;
}

$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false; // o servidor embutido entrega o arquivo
}

require __DIR__ . '/index.php';
return true;
