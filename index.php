<?php
/**
 * Ponto de entrada de todas as páginas. O .htaccess (Apache/HostGator) e o
 * router.php (servidor local) encaminham para cá qualquer URL que não seja
 * um arquivo existente.
 */
require __DIR__ . '/app/bootstrap.php';

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// /calibracao/ → /calibracao (uma única URL por página)
if ($path !== '/' && substr($path, -1) === '/') {
    $query = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: ' . rtrim($path, '/') . $query, true, 301);
    exit;
}
if ($path === '/index.php') {
    header('Location: /', true, 301);
    exit;
}

$paginas = config('paginas');

if ($path === '/robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "User-agent: *\nAllow: /\n\nSitemap: " . absolute_url('/sitemap.xml') . "\n";
    exit;
}
if ($path === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach (array_keys($paginas) as $url) {
        echo '  <url><loc>' . e(absolute_url($url)) . "</loc></url>\n";
    }
    echo "</urlset>\n";
    exit;
}

if (isset($paginas[$path])) {
    $pagina = $paginas[$path];
} else {
    http_response_code(404);
    $pagina = config('pagina_404');
    $path = null;
}

header('Content-Type: text/html; charset=utf-8');

// A view é renderizada antes do layout para que ela possa indicar o que usa
// (formulário, modal do certificado) ao rodapé.
ob_start();
require APP_DIR . '/views/pages/' . $pagina['view'] . '.php';
$conteudo = ob_get_clean();

require APP_DIR . '/views/layout/header.php';
echo $conteudo;
require APP_DIR . '/views/layout/footer.php';
