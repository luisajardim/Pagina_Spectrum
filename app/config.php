<?php
/**
 * Configuração central do site.
 *
 *  - links:   destinos dos botões externos (troque 'PENDENTE' pela URL real)
 *  - paginas: URL, título, descrição, logo do cabeçalho e contatos do rodapé
 *  - forms:   destinatários, assunto e campos validados de cada formulário
 */

return [

    // ------------------------------------------------------------------
    // Links dos botões. Valores especiais de 'url':
    //   'PENDENTE'  o botão só mostra o aviso abaixo
    //   'EM_BREVE'  idem, e aparece o selo "Em breve" ao lado do botão
    // Quando o sistema estiver pronto, troque pela URL real.
    // ------------------------------------------------------------------
    'links' => [
        'atendimento_minipa' => [
            'url'   => 'https://www.minipa.com.br/', // botão "Solicite atendimento MINIPA" (Equip. de Medição)
            'aviso' => 'Abrindo formulário de atendimento Minipa...',
        ],
        'certificado_medical' => [
            'url'   => 'EM_BREVE', // botão "Emitir certificado" (Spectrum Medical)
            'aviso' => 'A emissão de certificados pelo site estará disponível em breve.',
        ],
        'certificado_calibracao' => [
            'url'   => 'EM_BREVE', // botão "Emitir certificado" (Calibração)
            'aviso' => 'A emissão de certificados pelo site estará disponível em breve.',
        ],
    ],

    // ------------------------------------------------------------------
    // Páginas. 'logo': spectrum | minipa | medical
    //          'rodape': quais colunas de contato aparecem no rodapé
    //          'nav': item do menu marcado como ativo
    // ------------------------------------------------------------------
    'paginas' => [
        '/' => [
            'view'      => 'inicio',
            'titulo'    => 'Spectrum | Assistência técnica, calibração e locação em Belo Horizonte',
            'descricao' => 'A Spectrum reúne assistência técnica autorizada Minipa, atendimento multimarcas, manutenção de equipamentos médicos, locação e laboratório de calibração acreditado em Belo Horizonte.',
            'logo'      => 'spectrum',
            'rodape'    => ['medicos', 'locacao'],
            'nav'       => 'inicio',
        ],
        '/equipamentos-de-medicao' => [
            'view'      => 'equipamentos-de-medicao',
            'titulo'    => 'Assistência Técnica: Equipamentos de Medição | Spectrum',
            'descricao' => 'Assistência Técnica Autorizada Minipa (ASTEC) em Minas Gerais e atendimento a instrumentos de medição multimarcas: manutenção, garantia e calibração.',
            'logo'      => 'minipa',
            'rodape'    => ['locacao'],
            'nav'       => 'equipamentos-de-medicao',
        ],
        '/calibracao' => [
            'view'      => 'calibracao',
            'titulo'    => 'Calibração | Laboratório Acreditado LASEQ | Spectrum',
            'descricao' => 'Laboratório Spectrum - LASEQ: calibração rastreável em conformidade com a ABNT NBR ISO/IEC 17025. Acreditação CAL 0807 (Cgcre/Inmetro).',
            'logo'      => 'spectrum',
            'rodape'    => ['locacao'],
            'nav'       => 'calibracao',
        ],
        '/spectrum-medical' => [
            'view'      => 'spectrum-medical',
            'titulo'    => 'Spectrum Medical | Assistência Técnica: Equipamentos Médicos',
            'descricao' => 'Manutenção preventiva e corretiva, calibração e certificado de conformidade para equipamentos médicos, hospitalares, de estética e fisioterapia.',
            'logo'      => 'medical',
            'rodape'    => ['medicos'],
            'nav'       => 'spectrum-medical',
        ],
        '/spectrum-medical/contrato' => [
            'view'      => 'contrato',
            'titulo'    => 'Contrato de Manutenção | Spectrum Medical',
            'descricao' => 'Solicite uma proposta de contrato de manutenção preventiva e corretiva para equipamentos médicos, hospitalares, de estética ou fisioterapia.',
            // No protótipo esta sub-página usa o logo padrão e o rodapé completo.
            'logo'      => 'spectrum',
            'rodape'    => ['medicos', 'locacao'],
            'nav'       => null,
        ],
        '/locacao' => [
            'view'      => 'locacao',
            'titulo'    => 'Locação de Equipamentos de Medição | Spectrum',
            'descricao' => 'Instrumentos de medição disponíveis para locação, revisados e calibrados antes de cada entrega. Solicite um orçamento.',
            'logo'      => 'spectrum',
            'rodape'    => ['medicos', 'locacao'],
            'nav'       => 'locacao',
        ],
        '/fale-conosco' => [
            'view'      => 'fale-conosco',
            'titulo'    => 'Fale Conosco | Spectrum',
            'descricao' => 'Entre em contato com o Serviço de Atendimento ao Cliente da Spectrum: e-mail, telefone (31) 2519-4550 e WhatsApp.',
            'logo'      => 'spectrum',
            'rodape'    => ['medicos', 'locacao'],
            'nav'       => null,
        ],
    ],

    'pagina_404' => [
        'view'      => '404',
        'titulo'    => 'Página não encontrada | Spectrum',
        'descricao' => 'O endereço acessado não existe ou foi alterado.',
        'logo'      => 'spectrum',
        'rodape'    => ['medicos', 'locacao'],
        'nav'       => null,
    ],

    // ------------------------------------------------------------------
    // Formulários. 'campos' => nome => [rótulo no e-mail, obrigatório?, tipo]
    // Tipos: text | email | textarea | lista (checkboxes) | opcao (radio/select)
    // ------------------------------------------------------------------
    'forms' => [
        'multimarcas' => [
            'nome'          => 'Multimarcas: Solicitar Orçamento / Calibração',
            'para'          => ['spectrumbh@spectrumbh.com.br'],
            'pagina'        => '/equipamentos-de-medicao',
            'ancora'        => 'formMultimarcas',
            'campos' => [
                'nome'        => ['Nome', true, 'text'],
                'empresa'     => ['Empresa', false, 'text'],
                'documento'   => ['CNPJ ou CPF', false, 'text'],
                'telefone'    => ['Telefone', true, 'text'],
                'email'       => ['E-mail', true, 'email'],
                'equipamento' => ['Equipamento e marca', true, 'text'],
                'necessidade' => ['O que você precisa?', false, 'lista', ['Orçamento de manutenção', 'Orçamento de calibração']],
                'descricao'   => ['Descreva o problema ou a necessidade', false, 'textarea'],
            ],
        ],
        'chamado-medical' => [
            'nome'          => 'Spectrum Medical: Solicitar Chamado Técnico',
            'para'          => ['sirlene@spectrumbh.com.br', 'claudio.teixeira@spectrumbh.com.br'],
            'pagina'        => '/spectrum-medical',
            'ancora'        => 'formMedicos',
            'campos' => [
                'nome'        => ['Nome', true, 'text'],
                'empresa'     => ['Nome da empresa', false, 'text'],
                'documento'   => ['CNPJ ou CPF do responsável', false, 'text'],
                'equipamento' => ['Qual equipamento precisa de atendimento', true, 'text'],
                'marca'       => ['Qual a marca do equipamento', false, 'text'],
                'garantia'    => ['O equipamento está em garantia de fábrica?', false, 'opcao', ['Sim', 'Não']],
                'assistencia' => ['Tipo de assistência necessária', false, 'opcao', ['Preventiva + Calibração', 'Corretiva + Calibração']],
                'descricao'   => ['Descreva o problema que o equipamento apresenta', false, 'textarea'],
            ],
        ],
        'contrato' => [
            'nome'          => 'Spectrum Medical: Proposta para Contrato de Manutenção',
            'para'          => ['spectrumbh@spectrumbh.com.br'],
            'pagina'        => '/spectrum-medical/contrato',
            'ancora'        => 'formContrato',
            'campos' => [
                'nome'         => ['Nome completo', true, 'text'],
                'email'        => ['E-mail', true, 'email'],
                'telefone'     => ['Telefone', true, 'text'],
                'empresa'      => ['Empresa / Instituição', false, 'text'],
                'documento'    => ['CNPJ ou CPF do responsável', false, 'text'],
                'equipamentos' => ['Quantidade e tipo de equipamentos', false, 'text'],
                'mensagem'     => ['Mensagem', true, 'textarea'],
            ],
        ],
        'locacao' => [
            'nome'          => 'Locação: Solicitar Orçamento',
            'para'          => ['spectrumbh@spectrumbh.com.br'],
            'pagina'        => '/locacao',
            'ancora'        => 'formLocacao',
            'campos' => [
                'nome'        => ['Nome', true, 'text'],
                'cnpj'        => ['CNPJ da empresa', false, 'text'],
                'telefone'    => ['Telefone', true, 'text'],
                'email'       => ['E-mail', true, 'email'],
                'equipamento' => ['Equipamento de interesse', false, 'text'],
                'diarias'     => ['Nº de diárias', false, 'text'],
                'periodo'     => ['Período (de / até)', false, 'text'],
                'estado'      => ['Estado de entrega', false, 'text'],
            ],
        ],
        'fale-conosco' => [
            'nome'          => 'Fale Conosco',
            'para'          => ['spectrumbh@spectrumbh.com.br'],
            'pagina'        => '/fale-conosco',
            'ancora'        => 'formFaleConosco',
            'campos' => [
                'nome'     => ['Nome completo', true, 'text'],
                'email'    => ['E-mail', true, 'email'],
                'telefone' => ['Telefone', true, 'text'],
                'estado'   => ['Estado', true, 'opcao', ['Minas Gerais', 'Outro']],
                'tipo'     => ['Tipo de solicitação', true, 'text'],
                'assunto'  => ['Assunto', true, 'text'],
                'mensagem' => ['Mensagem', true, 'textarea'],
            ],
        ],
    ],

    'mensagens_erro' => [
        'envio'       => 'Não foi possível enviar sua solicitação agora. Tente novamente em instantes ou fale conosco pelo telefone (31) 2519-4550.',
        'validacao'   => 'Preencha corretamente todos os campos obrigatórios (*) e tente novamente.',
        'verificacao' => 'Não foi possível confirmar que o envio foi feito por uma pessoa. Recarregue a página e tente novamente.',
        'limite'      => 'Muitas solicitações em pouco tempo. Aguarde alguns minutos e tente novamente.',
    ],
];
