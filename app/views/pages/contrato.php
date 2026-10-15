<section class="page" id="page-contrato">
  <div class="wrap page-hero">
    <p class="breadcrumb is-link-only"><a class="as-btn" href="/spectrum-medical">← Voltar para Spectrum Medical</a></p>
    <p class="eyebrow is-medical">Spectrum Medical</p>
    <h1 class="page-title display">Solicite Proposta para Contrato de Manutenção</h1>
    <p class="page-lede">Preencha os dados abaixo para receber uma proposta de contrato de manutenção preventiva e corretiva para seus equipamentos médicos, hospitalares, de estética ou fisioterapia.</p>

    <div class="subhead"><span class="sh-index mono">01</span><h2>Envie um E-mail</h2></div>
    <div class="subcard">
      <?php list($formClasses, $formError) = form_state('contrato'); $usaFormulario = true; ?>
      <form class="pform<?= $formClasses ?>" id="formContrato" action="/enviar.php" method="post" data-ajax>
        <div class="form-fields">
          <?= form_hidden_fields('contrato') ?>
          <div class="field"><label for="contrato-nome">Nome completo <span class="req">*</span></label><input type="text" id="contrato-nome" name="nome" autocomplete="name" required></div>
          <div class="field"><label for="contrato-email">E-mail <span class="req">*</span></label><input type="email" id="contrato-email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="contrato-telefone">Telefone <span class="req">*</span></label><input type="tel" id="contrato-telefone" name="telefone" autocomplete="tel" required></div>
          <div class="field"><label for="contrato-empresa">Empresa / Instituição</label><input type="text" id="contrato-empresa" name="empresa" autocomplete="organization"></div>
          <div class="field"><label for="contrato-documento">CNPJ ou CPF do responsável</label><input type="text" id="contrato-documento" name="documento"></div>
          <div class="field"><label for="contrato-equipamentos">Quantidade e tipo de equipamentos</label><input type="text" id="contrato-equipamentos" name="equipamentos"></div>
          <div class="field full"><label for="contrato-mensagem">Mensagem <span class="req">*</span></label><textarea id="contrato-mensagem" name="mensagem" required></textarea></div>
          <?= turnstile_widget() ?>
          <div class="form-actions">
            <button type="submit" class="btn btn-medical">Enviar Solicitação</button>
          </div>
        </div>
        <div class="form-success is-medical" role="status" tabindex="-1">✓ Solicitação enviada com sucesso! Nossa equipe entrará em contato em breve.</div>
        <div class="form-error" role="alert" tabindex="-1"><?= e($formError ?: default_error_message()) ?></div>
      </form>
      <p class="btn-note" style="margin-top:16px;">Você também pode entrar em contato diretamente pelo e-mail: <a href="mailto:spectrumbh@spectrumbh.com.br">spectrumbh@spectrumbh.com.br</a></p>
    </div>
  </div>
</section>
