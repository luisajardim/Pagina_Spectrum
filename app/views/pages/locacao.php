<section class="page" id="page-locacao">
  <div class="wrap page-hero">
    <p class="eyebrow">Locação de Equipamentos</p>
    <h1 class="page-title display">Locação</h1>
    <p class="page-lede">Instrumentos de medição disponíveis para locação, revisados e calibrados antes de cada entrega.</p>

    <div class="subhead"><span class="sh-index mono">01</span><h2>Solicitar Orçamento de Locação</h2></div>
    <div class="subcard">
      <?php list($formClasses, $formError) = form_state('locacao'); $usaFormulario = true; ?>
      <form class="pform<?= $formClasses ?>" id="formLocacao" action="/enviar.php" method="post" data-ajax>
        <div class="form-fields">
          <?= form_hidden_fields('locacao') ?>
          <div class="field"><label for="locacao-nome">Nome <span class="req">*</span></label><input type="text" id="locacao-nome" name="nome" autocomplete="name" required></div>
          <div class="field"><label for="locacao-cnpj">CNPJ da empresa</label><input type="text" id="locacao-cnpj" name="cnpj"></div>
          <div class="field"><label for="locacao-telefone">Telefone <span class="req">*</span></label><input type="tel" id="locacao-telefone" name="telefone" autocomplete="tel" required></div>
          <div class="field"><label for="locacao-email">E-mail <span class="req">*</span></label><input type="email" id="locacao-email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="locacao-equipamento">Equipamento de interesse</label><input type="text" id="locacao-equipamento" name="equipamento"></div>
          <div class="field"><label for="locacao-diarias">Nº de diárias</label><input type="text" id="locacao-diarias" name="diarias"></div>
          <div class="field"><label for="locacao-periodo">Período (de / até)</label><input type="text" id="locacao-periodo" name="periodo"></div>
          <div class="field"><label for="locacao-estado">Estado de entrega</label><input type="text" id="locacao-estado" name="estado"></div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Solicitar locação</button>
            <?= turnstile_widget() ?>
          </div>
        </div>
        <div class="form-success" role="status" tabindex="-1">✓ Solicitação de locação enviada com sucesso! Nossa equipe entrará em contato em breve.</div>
        <div class="form-error" role="alert" tabindex="-1"><?= e($formError ?: default_error_message()) ?></div>
      </form>
    </div>
  </div>
<div class="subhead"><span class="sh-index mono">02</span><h2>Catálogo de Locação de Equipamentos</h2></div>
    <div class="subcard">
      <div style="overflow-x:auto;">
        <table class="rental-table">
          <thead>
            <tr><th>Equipamentos</th><th>Modelo/Fabricante</th></tr>
          </thead>
          <tbody>
            <tr><td>MCR - 1 SPDA</td><td>Spectrum</td></tr>
            <tr><td>IRT - 101 Monofásico</td><td>Spectrum</td></tr>
            <tr><td>ICS - 104</td><td>Spectrum</td></tr>
            <tr><td>Hipot HPA 5070</td><td>Importado</td></tr>
            <tr><td>Terrômetro MTR 1522</td><td>Minipa</td></tr>
            <tr><td>Megôhmetro 5kV MI2705</td><td>Minipa</td></tr>
            <tr><td>Megôhmetro 15kV MI2715</td><td>Minipa</td></tr>
            <tr><td>Tangente Delta MFP 10kV</td><td>Minipa</td></tr>
            <tr><td>Terrômetro MTD 20kWe</td><td>Megabras</td></tr>
            <tr><td>Hipot HPA 1205 120kV 5mA</td><td>Minipa</td></tr>
            <tr><td>Analisador de Energia</td><td>Minipa</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    </section>
