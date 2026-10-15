<section class="page" id="page-faleconosco">
  <div class="wrap page-hero">
    <p class="breadcrumb"><a class="as-btn" href="/">Início</a> / Fale Conosco</p>
    <p class="eyebrow">Atendimento</p>
    <h1 class="page-title display">Fale Conosco</h1>
    <p class="page-lede">O Serviço de Atendimento ao Cliente da Spectrum tem a função de prestar informações e esclarecer dúvidas sobre nossos produtos e serviços. Nesta página, você pode enviar uma solicitação preenchendo seus dados abaixo e posteriormente acompanhar via e-mail.</p>

    <div class="subhead"><span class="sh-index mono">01</span><h2>Envie um E-mail</h2></div>
    <div class="subcard">
      <?php list($formClasses, $formError) = form_state('fale-conosco'); $usaFormulario = true; ?>
      <form class="pform<?= $formClasses ?>" id="formFaleConosco" action="/enviar.php" method="post" data-ajax>
        <div class="form-fields">
          <?= form_hidden_fields('fale-conosco') ?>
          <div class="field"><label for="fale-conosco-nome">Nome completo <span class="req">*</span></label><input type="text" id="fale-conosco-nome" name="nome" autocomplete="name" required></div>
          <div class="field"><label for="fale-conosco-email">E-mail <span class="req">*</span></label><input type="email" id="fale-conosco-email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="fale-conosco-telefone">Telefone <span class="req">*</span></label><input type="tel" id="fale-conosco-telefone" name="telefone" autocomplete="tel" required></div>
          <div class="field">
            <label for="fale-conosco-estado">Estado <span class="req">*</span></label>
            <select id="fale-conosco-estado" name="estado" required>
              <option value="" selected disabled>Selecione seu estado</option>
              <option>Minas Gerais</option>
              <option>Outro</option>
            </select>
          </div>
          <div class="field"><label for="fale-conosco-tipo">Tipo de solicitação <span class="req">*</span></label><input type="text" id="fale-conosco-tipo" name="tipo" value="Contato Geral" required></div>
          <div class="field"><label for="fale-conosco-assunto">Assunto <span class="req">*</span></label><input type="text" id="fale-conosco-assunto" name="assunto" required></div>
          <div class="field full"><label for="fale-conosco-mensagem">Mensagem <span class="req">*</span></label><textarea id="fale-conosco-mensagem" name="mensagem" required></textarea></div>
          <?= turnstile_widget() ?>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
          </div>
        </div>
        <div class="form-success" role="status" tabindex="-1">✓ Solicitação enviada com sucesso! Nossa equipe entrará em contato em breve.</div>
        <div class="form-error" role="alert" tabindex="-1"><?= e($formError ?: default_error_message()) ?></div>
      </form>
      <p class="btn-note" style="margin-top:16px;">Você também pode entrar em contato diretamente pelo e-mail: <a href="mailto:spectrumbh@spectrumbh.com.br">spectrumbh@spectrumbh.com.br</a></p>
    </div>

    <div class="subhead"><span class="sh-index mono">02</span><h2>Telefones e E-mails Úteis</h2></div>
    <div class="subcard">
      <div class="contact-grid">
        <div class="contact-item">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
          <div><div class="ci-label">SAC</div><div class="ci-value">spectrumbh@spectrumbh.com.br</div></div>
        </div>
        <div class="contact-item">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.4 2.1L8 9.8a16 16 0 0 0 6 6l1.2-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.7.6a2 2 0 0 1 2 2.1z"/></svg></span>
          <div><div class="ci-label">Telefone</div><div class="ci-value">(31) 2519-4550</div></div>
        </div>
        <div class="contact-item">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
          <div><div class="ci-label">WhatsApp</div><div class="ci-value">(31) 99797-0551</div></div>
        </div>
      </div>
    </div>
  </div>
</section>
