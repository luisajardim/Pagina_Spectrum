<?php
/**
 * Rodapé compartilhado. As colunas de contato exibidas vêm de
 * config.php → paginas → 'rodape'.
 */
$waIcon = '<svg class="wa-icon" viewBox="0 0 24 24" fill="#25D366" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.85.5 3.58 1.35 5.08L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm5.78 14.1c-.24.68-1.4 1.32-1.93 1.4-.5.08-1.12.11-1.8-.11-.42-.13-.96-.31-1.65-.6-2.9-1.25-4.8-4.16-4.94-4.35-.14-.19-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.41.27-.29.58-.36.78-.36.2 0 .39 0 .56.01.18.01.42-.07.65.5.24.58.83 2 .9 2.15.07.14.12.31.02.5-.1.19-.15.31-.29.48-.14.17-.3.38-.43.51-.14.14-.29.29-.13.57.17.29.75 1.24 1.61 2.01 1.11 1 2.05 1.31 2.34 1.46.29.14.46.12.63-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.63-.14.26.1 1.63.77 1.91.91.29.14.48.22.55.34.07.13.07.71-.17 1.39z"/></svg>';
?>
</main>

<footer class="site" id="siteFooter">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a class="wordmark as-btn" href="/" style="margin-bottom:12px;">
          <img class="brand-logo" src="<?= e(asset('img/logo-spectrum.webp')) ?>" alt="Spectrum" width="350" height="52" loading="lazy">
        </a>
        <p>Precisão que gera confiança. Excelência que impulsiona resultados. Belo Horizonte, MG.</p>
      </div>
      <nav class="foot-col" aria-label="Rodapé">
        <h5>Navegação</h5>
        <ul>
          <li><a class="as-btn" href="/equipamentos-de-medicao">Assistência Técnica: Equip. de Medição</a></li>
          <li><a class="as-btn" href="/calibracao">Calibração</a></li>
          <li><a class="as-btn" href="/spectrum-medical">Spectrum Medical</a></li>
          <li><a class="as-btn" href="/locacao">Locação</a></li>
          <li><a class="as-btn" href="/fale-conosco">Fale Conosco</a></li>
        </ul>
      </nav>
<?php if (in_array('medicos', $pagina['rodape'], true)): ?>
      <div class="foot-col foot-col-medicos">
        <h5>Equipamentos médicos</h5>
        <ul>
          <li class="mono">Tel (31) 2519-4550</li>
          <li><a class="mono wa-link" href="https://wa.me/553125194552" target="_blank" rel="noopener"><?= $waIcon ?>WhatsApp (31) 2519-4552</a></li>
        </ul>
      </div>
<?php endif; ?>
<?php if (in_array('locacao', $pagina['rodape'], true)): ?>
      <div class="foot-col foot-col-locacao">
        <h5>Locação e multimarcas</h5>
        <ul>
          <li class="mono">Tel (31) 2519-4550</li>
          <li><a class="mono wa-link" href="https://wa.me/5531997970551" target="_blank" rel="noopener"><?= $waIcon ?>WhatsApp (31) 99797-0551</a></li>
          <li><a href="mailto:spectrumbh@spectrumbh.com.br">spectrumbh@spectrumbh.com.br</a></li>
        </ul>
      </div>
<?php endif; ?>
    </div>
    <div class="foot-bottom">
      <span>© 2026 Spectrum Equipamentos Comércio e Serviços Ltda.</span>
    </div>
  </div>
</footer>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<?php if (!empty($usaModalCertificado)) require APP_DIR . '/views/partials/cert-modal.php'; ?>
<?php if (!empty($usaFormulario) && env('TURNSTILE_SITE_KEY')): ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif; ?>
<script src="<?= e(asset('js/site.js')) ?>" defer></script>
</body>
</html>
