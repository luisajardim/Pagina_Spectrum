<section class="page" id="page-equipmedicao">
  <div class="wrap page-hero">
    <p class="eyebrow">Spectrum Equipamentos</p>
    <h1 class="page-title display">Assistência Técnica: Equipamentos de Medição</h1>
    <p class="page-lede">A Spectrum é a Assistência Técnica Autorizada Minipa (ASTEC) em Minas Gerais e atende, também, instrumentos de medição multimarcas.</p>

    <div class="subhead"><span class="sh-index mono">01</span><h2>Manutenção / Garantia (Minipa)</h2></div>
    <div class="subcard">
      <p class="page-lede" style="margin-bottom:20px;">Soluções Especializadas para manter seus equipamentos Minipa em pleno funcionamento, com segurança, qualidade e confiabilidade.</p>
      <div class="btn-row">
        <a class="btn btn-primary as-btn" id="btnGoogleForm" <?= link_attrs('atendimento_minipa') ?>>Solicite atendimento MINIPA</a>
      </div>
    </div>

    <div class="subhead"><span class="sh-index mono">02</span><h2>Equipamentos Multimarcas: Solicitar Orçamento / Calibração</h2></div>
    <div class="subcard">
      <p class="page-lede" style="margin-bottom:20px;">Atendemos equipamentos de diferentes marcas com a mesma segurança, qualidade e confiabilidade.</p>
      <?php list($formClasses, $formError) = form_state('multimarcas'); $usaFormulario = true; ?>
      <form class="pform<?= $formClasses ?>" id="formMultimarcas" action="/enviar.php" method="post" data-ajax>
        <div class="form-fields">
          <?= form_hidden_fields('multimarcas') ?>
          <div class="field"><label for="multimarcas-nome">Nome <span class="req">*</span></label><input type="text" id="multimarcas-nome" name="nome" autocomplete="name" required></div>
          <div class="field"><label for="multimarcas-empresa">Empresa</label><input type="text" id="multimarcas-empresa" name="empresa" autocomplete="organization"></div>
          <div class="field"><label for="multimarcas-documento">CNPJ ou CPF</label><input type="text" id="multimarcas-documento" name="documento"></div>
          <div class="field"><label for="multimarcas-telefone">Telefone <span class="req">*</span></label><input type="tel" id="multimarcas-telefone" name="telefone" autocomplete="tel" required></div>
          <div class="field"><label for="multimarcas-email">E-mail <span class="req">*</span></label><input type="email" id="multimarcas-email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="multimarcas-equipamento">Equipamento e marca <span class="req">*</span></label><input type="text" id="multimarcas-equipamento" name="equipamento" required></div>
          <div class="field full">
            <label id="multimarcas-necessidade-label">O que você precisa? <span class="helper-text" style="display:block; font-weight:400;">Selecione uma ou as duas opções</span></label>
            <div class="radio-row" role="group" aria-labelledby="multimarcas-necessidade-label">
              <label><input type="checkbox" name="necessidade[]" value="Orçamento de manutenção"> Orçamento de manutenção</label>
              <label><input type="checkbox" name="necessidade[]" value="Orçamento de calibração"> Orçamento de calibração</label>
            </div>
          </div>
          <div class="field full"><label for="multimarcas-descricao">Descreva o problema ou a necessidade</label><textarea id="multimarcas-descricao" name="descricao"></textarea></div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enviar solicitação</button>
            <?= turnstile_widget() ?>
          </div>
        </div>
        <div class="form-success" role="status" tabindex="-1">✓ Solicitação enviada com sucesso! Em breve nossa equipe entrará em contato.</div>
        <div class="form-error" role="alert" tabindex="-1"><?= e($formError ?: default_error_message()) ?></div>
      </form>
    </div>

    <div class="subhead"><span class="sh-index mono">03</span><h2>Catálogo de Manutenção</h2></div>
    <div class="subcard">
      <p class="helper-text" style="margin-bottom:16px;">Relação de equipamentos atendidos em manutenção e calibração pela Spectrum (multimarcas). Use a busca para localizar um equipamento específico.</p>
      <div class="search-row">
        <div class="search-box">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
          <input type="text" id="equipSearch" placeholder="Buscar equipamento, ex.: osciloscópio">
        </div>
        <span class="search-count mono" id="equipCount">50 itens</span>
      </div>
      <div class="pchip-grid" id="equipGrid">
<button class="pchip" type="button" data-name="alicates amperímetros analógicos/digitais">Alicates Amperímetros Analógicos/Digitais</button>
<button class="pchip" type="button" data-name="alicates terrômetros">Alicates Terrômetros</button>
<button class="pchip" type="button" data-name="alicate wattímetro">Alicate Wattímetro</button>
<button class="pchip" type="button" data-name="analisador de energia">Analisador de Energia</button>
<button class="pchip" type="button" data-name="analisador de disjuntores">Analisador de Disjuntores</button>
<button class="pchip" type="button" data-name="caixa de calibração de relé monofásica / trifásica / hexafásica">Caixa de Calibração de Relé Monofásica / Trifásica / Hexafásica</button>
<button class="pchip" type="button" data-name="calibrador de processos">Calibrador de Processos</button>
<button class="pchip" type="button" data-name="calibradores de ma/mv/a">Calibradores de Ma/Mv/a</button>
<button class="pchip" type="button" data-name="carga artificial cpa48/50">Carga Artificial Cpa48/50</button>
<button class="pchip" type="button" data-name="capacetes">Capacetes</button>
<button class="pchip" type="button" data-name="capacímetros">Capacímetros</button>
<button class="pchip" type="button" data-name="célula de óleo - cuba">Célula de Óleo - Cuba</button>
<button class="pchip" type="button" data-name="década resistiva">Década Resistiva</button>
<button class="pchip" type="button" data-name="decibelímetro">Decibelímetro</button>
<button class="pchip" type="button" data-name="detector de tensão">Detector de Tensão</button>
<button class="pchip" type="button" data-name="divisor de alta tensão">Divisor de Alta Tensão</button>
<button class="pchip" type="button" data-name="fonte de alimentação dc - simples/dupla">Fonte de Alimentação Dc - Simples/Dupla</button>
<button class="pchip" type="button" data-name="fonte de corrente">Fonte de Corrente</button>
<button class="pchip" type="button" data-name="foto tacômetro">Foto Tacômetro</button>
<button class="pchip" type="button" data-name="frequencímetro analógico/digital">Frequencímetro Analógico/Digital</button>
<button class="pchip" type="button" data-name="gerador de áudio / função / sinal">Gerador de Áudio / Função / Sinal</button>
<button class="pchip" type="button" data-name="hipots de baixa e alta tensão">Hipots de Baixa e Alta Tensão</button>
<button class="pchip" type="button" data-name="indicador de resistência ohmica">Indicador de Resistência Ohmica</button>
<button class="pchip" type="button" data-name="indicador relação de transformação">Indicador Relação de Transformação</button>
<button class="pchip" type="button" data-name="kilovoltímetros">Kilovoltímetros</button>
<button class="pchip" type="button" data-name="luvas isolantes">Luvas Isolantes</button>
<button class="pchip" type="button" data-name="medidor de curva de saturação">Medidor de Curva de Saturação</button>
<button class="pchip" type="button" data-name="medidor de energia - smarten">Medidor de Energia - Smarten</button>
<button class="pchip" type="button" data-name="medidor de fator de potência">Medidor de Fator de Potência</button>
<button class="pchip" type="button" data-name="medidor de lcr">Medidor de Lcr</button>
<button class="pchip" type="button" data-name="megôhmetros digitais">Megôhmetros Digitais</button>
<button class="pchip" type="button" data-name="miliohmímetro digital">Miliohmímetro Digital</button>
<button class="pchip" type="button" data-name="micrôohmímetros">Micrôohmímetros</button>
<button class="pchip" type="button" data-name="multimedidor de energia">Multimedidor de Energia</button>
<button class="pchip" type="button" data-name="multímetros">Multímetros</button>
<button class="pchip" type="button" data-name="osciloscópios analógico / digital">Osciloscópios Analógico / Digital</button>
<button class="pchip" type="button" data-name="pinça amperimétrica">Pinça Amperimétrica</button>
<button class="pchip" type="button" data-name="polarímetros">Polarímetros</button>
<button class="pchip" type="button" data-name="ponta de alta tensão">Ponta de Alta Tensão</button>
<button class="pchip" type="button" data-name="ponte de capacitância">Ponte de Capacitância</button>
<button class="pchip" type="button" data-name="ponte de kelvin">Ponte de Kelvin</button>
<button class="pchip" type="button" data-name="ponte de wheatstone">Ponte de Wheatstone</button>
<button class="pchip" type="button" data-name="ponte lcr">Ponte Lcr</button>
<button class="pchip" type="button" data-name="tangente delta">Tangente Delta</button>
<button class="pchip" type="button" data-name="terrômetro analógico / digital">Terrômetro Analógico / Digital</button>
<button class="pchip" type="button" data-name="termo-higrômetro">Termo-higrômetro</button>
<button class="pchip" type="button" data-name="testador de rigidez">Testador de Rigidez</button>
<button class="pchip" type="button" data-name="vara de manobra">Vara de Manobra</button>
<button class="pchip" type="button" data-name="voltímetro analógico / digital">Voltímetro Analógico / Digital</button>
<button class="pchip" type="button" data-name="wattímetro analógico / digital">Wattímetro Analógico / Digital</button>
      </div>
      <p class="empty-note" id="equipEmpty">Nenhum equipamento encontrado para essa busca.</p>
    </div>

    <div class="subhead"><span class="sh-index mono">04</span><h2>Contato</h2></div>
    <div class="subcard">
      <div class="contact-grid">
        <div class="contact-item">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
          <div><div class="ci-label">E-mail</div><div class="ci-value">spectrumbh@spectrumbh.com.br</div></div>
        </div>
        <div class="contact-item">
          <span class="ci-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16.5v2a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.2 2 2 0 0 1 3.1 1h2a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.4 2.1L6.1 8.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.9 2.8z"/></svg></span>
          <div><div class="ci-label">Celular / WhatsApp</div><div class="ci-value">(31) 2519-4550</div></div>
        </div>
      </div>
    </div>
  </div>
</section>
