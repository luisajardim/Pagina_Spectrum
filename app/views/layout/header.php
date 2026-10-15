<?php
/**
 * Cabeçalho compartilhado. Espera $pagina (config.php → paginas) e $path.
 */
$logos = [
    'spectrum' => ['img/logo-spectrum.webp', 'Spectrum'],
    'minipa'   => ['img/logo-spectrum-by-minipa.webp', 'Spectrum by Minipa'],
    'medical'  => ['img/logo-spectrum-medical.webp', 'Spectrum Medical'],
];
list($logoSrc, $logoAlt) = $logos[$pagina['logo']];

$menu = [
    'inicio'                  => ['/', 'Início'],
    'equipamentos-de-medicao' => ['/equipamentos-de-medicao', 'Assistência Técnica: Equip. de Medição'],
    'calibracao'              => ['/calibracao', 'Calibração'],
    'spectrum-medical'        => ['/spectrum-medical', 'Spectrum Medical'],
    'locacao'                 => ['/locacao', 'Locação'],
];
$canonical = $path === null ? null : absolute_url($path);
?><!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pagina['titulo']) ?></title>
<meta name="description" content="<?= e($pagina['descricao']) ?>">
<?php if ($canonical): ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<?php else: ?>
<meta name="robots" content="noindex">
<?php endif; ?>
<meta name="theme-color" content="#2D49A0">
<meta property="og:type" content="website">
<meta property="og:locale" content="pt_BR">
<meta property="og:site_name" content="Spectrum">
<meta property="og:title" content="<?= e($pagina['titulo']) ?>">
<meta property="og:description" content="<?= e($pagina['descricao']) ?>">
<?php if ($canonical): ?>
<meta property="og:url" content="<?= e($canonical) ?>">
<?php endif; ?>
<meta property="og:image" content="<?= e(absolute_url('/assets/img/og-spectrum.jpg')) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Logo Spectrum sobre fotos de instrumentos de medição">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/img/icon-192.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo+Expanded:wght@600;700;800&family=IBM+Plex+Sans:ital,wght@0,400;0,500;0,600;1,400&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>">
</head>
<body>
<a class="skip-link" href="#conteudo">Pular para o conteúdo</a>

<header class="site">
  <nav class="nav" aria-label="Principal">
    <a class="wordmark as-btn" href="/">
      <img class="brand-logo" id="headerLogo" src="<?= e(asset($logoSrc)) ?>" alt="<?= e($logoAlt) ?>" width="350" height="52">
    </a>
    <ul class="navlinks">
<?php foreach ($menu as $key => $item): $active = $pagina['nav'] === $key; ?>
      <li><a class="as-btn<?= $active ? ' active' : '' ?>" href="<?= e($item[0]) ?>"<?= $active ? ' aria-current="page"' : '' ?>><?= e($item[1]) ?></a></li>
<?php endforeach; ?>
    </ul>
    <div class="navcta">
      <a class="btn btn-ghost as-btn" href="/fale-conosco">Fale Conosco</a>
      <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobileMenu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>
    </div>
  </nav>
  <div class="mobile-menu" id="mobileMenu">
<?php foreach ($menu as $key => $item): ?>
    <a class="as-btn" href="<?= e($item[0]) ?>"<?= $pagina['nav'] === $key ? ' aria-current="page"' : '' ?>><?= e($item[1]) ?></a>
<?php endforeach; ?>
    <a class="as-btn" href="/fale-conosco"<?= $path === '/fale-conosco' ? ' aria-current="page"' : '' ?>>Fale Conosco</a>
  </div>
</header>

<?php if ($path !== '/'): ?>
<a class="back-btn show as-btn" href="/" aria-label="Voltar para a página inicial">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
  Início
</a>
<?php endif; ?>

<main id="conteudo">
