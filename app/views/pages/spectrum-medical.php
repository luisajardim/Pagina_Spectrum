<section class="page" id="page-medicos">
  <div class="wrap page-hero">
    <p class="eyebrow is-medical">Spectrum Medical</p>
    <h1 class="page-title display">Assistência Técnica: Equipamentos Médicos</h1>
    <p class="page-lede">Manutenção preventiva e corretiva, calibração e emissão de certificado de conformidade para equipamentos médicos, hospitalares, de estética e fisioterapia.</p>
    <div class="btn-row">
      <a class="btn btn-outline-medical as-btn" href="/spectrum-medical/contrato">Solicite proposta para contrato de manutenção →</a>
    </div>

    <div class="subhead is-medical"><span class="sh-index mono">01</span><h2>Solicitar Chamado Técnico</h2></div>
    <div class="subcard">
      <?php list($formClasses, $formError) = form_state('chamado-medical'); $usaFormulario = true; ?>
      <form class="pform<?= $formClasses ?>" id="formMedicos" action="/enviar.php" method="post" data-ajax>
        <div class="form-fields">
          <?= form_hidden_fields('chamado-medical') ?>
          <div class="field"><label for="chamado-medical-nome">Nome <span class="req">*</span></label><input type="text" id="chamado-medical-nome" name="nome" autocomplete="name" required></div>
          <div class="field"><label for="chamado-medical-empresa">Nome da empresa</label><input type="text" id="chamado-medical-empresa" name="empresa" autocomplete="organization"></div>
          <div class="field"><label for="chamado-medical-documento">CNPJ ou CPF do responsável</label><input type="text" id="chamado-medical-documento" name="documento"></div>
          <div class="field"><label for="chamado-medical-equipamento">Qual equipamento precisa de atendimento <span class="req">*</span></label><input type="text" id="chamado-medical-equipamento" name="equipamento" required></div>
          <div class="field"><label for="chamado-medical-marca">Qual a marca do equipamento</label><input type="text" id="chamado-medical-marca" name="marca"></div>
          <div class="field">
            <label id="chamado-medical-garantia-label">O equipamento está em garantia de fábrica?</label>
            <div class="radio-row" role="radiogroup" aria-labelledby="chamado-medical-garantia-label"><label><input type="radio" name="garantia" value="Sim" checked> Sim</label><label><input type="radio" name="garantia" value="Não"> Não</label></div>
          </div>
          <div class="field full">
            <label id="chamado-medical-assistencia-label">Tipo de assistência necessária</label>
            <div class="radio-row" role="radiogroup" aria-labelledby="chamado-medical-assistencia-label">
              <label><input type="radio" name="assistencia" value="Preventiva + Calibração" checked> Preventiva + Calibração</label>
              <label><input type="radio" name="assistencia" value="Corretiva + Calibração"> Corretiva + Calibração</label>
            </div>
          </div>
          <div class="field full"><label for="chamado-medical-descricao">Descreva o problema que o equipamento apresenta</label><textarea id="chamado-medical-descricao" name="descricao"></textarea></div>
          <div class="form-actions">
            <button type="submit" class="btn btn-medical">Enviar chamado técnico</button>
            <?= turnstile_widget() ?>
          </div>
        </div>
        <div class="form-success is-medical" role="status" tabindex="-1">✓ Chamado técnico enviado com sucesso! Nossa equipe entrará em contato em breve.</div>
        <div class="form-error" role="alert" tabindex="-1"><?= e($formError ?: default_error_message()) ?></div>
      </form>
    </div>

    <div class="subhead is-medical"><span class="sh-index mono">02</span><h2>Certificado</h2></div>
    <div class="subcard">
      <p class="page-lede" style="margin-bottom:20px;">Após a conclusão do serviço, o certificado de conformidade do equipamento fica disponível para emissão diretamente pelo sistema interno da Spectrum, necessário para fins de fiscalização da vigilância sanitária local.</p>
      <div class="btn-row">
        <a class="btn btn-medical as-btn" id="btnCertMedico" <?= link_attrs('certificado_medical') ?>>Emitir certificado</a>
        <?= link_badge('certificado_medical') ?>
      </div>
    </div>
  </div>
<div class="subhead is-medical"><span class="sh-index mono">03</span><h2>Catálogo de Manutenção</h2></div>
    <div class="subcard">
      <div class="med-group">
        <h4 class="med-group-title grp-hosp">Hospitalar / Suporte à Vida</h4>
        <div class="chips"><span class="chip">Oxímetro</span>
<span class="chip">Monitor Multiparamétrico</span>
<span class="chip">Cardioversor</span>
<span class="chip">Aparelho de Anestesia</span>
<span class="chip">Ventilador Pulmonar</span>
<span class="chip">Eletrocardiógrafo</span>
<span class="chip">Sistema de Compressão Pneumática</span>
<span class="chip">Desfibrilador</span></div>
      </div>
<div class="med-group">
        <h4 class="med-group-title grp-diag">Diagnóstico</h4>
        <div class="chips"><span class="chip">Ultrassom</span></div>
      </div>
<div class="med-group">
        <h4 class="med-group-title grp-est">Estética</h4>
        <div class="chips"><span class="chip">Laser de Epilação</span>
<span class="chip">Alta Frequência</span>
<span class="chip">Eletroestimulação</span>
<span class="chip">Radiofrequência</span>
<span class="chip">Ultrassom Micro e Macrofocado</span>
<span class="chip">Campo Eletromagnético de Alta Intensidade</span>
<span class="chip">Vapor de Ozônio</span>
<span class="chip">Laser Removedor de Pigmento</span>
<span class="chip">Vacuoterapia</span>
<span class="chip">Jato de Plasma</span>
<span class="chip">Peeling Ultrassônico</span>
<span class="chip">Criolipólise</span>
<span class="chip">Luz Intensa Pulsada</span></div>
      </div>
      <div class="other-areas">Também atendemos equipamentos das áreas de <strong>fisioterapia</strong>, <strong>odontologia</strong> e <strong>laboratorial</strong> — lista detalhada de tipos a complementar com a Spectrum.</div>
    </div>

    <div class="subhead is-medical"><span class="sh-index mono">04</span><h2>Contato</h2></div>
    <div class="subcard">
      <div class="contact-grid">
        <div class="contact-item is-medical">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.4 2.1L8 9.8a16 16 0 0 0 6 6l1.2-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.7.6a2 2 0 0 1 2 2.1z"/></svg></span>
          <div><div class="ci-label">Telefone</div><div class="ci-value">(31) 2519-4550</div></div>
        </div>
        <div class="contact-item is-medical">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
          <div><div class="ci-label">WhatsApp</div><div class="ci-value">(31) 2519-4552</div></div>
        </div>
      </div>
    </div>

    </section>
