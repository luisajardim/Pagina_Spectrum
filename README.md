# Site Spectrum

Site institucional da Spectrum (Belo Horizonte), construído a partir do protótipo aprovado
`spectrumprototipo_v33.html`. É PHP simples, sem etapa de build e sem banco de dados, feito
para rodar em hospedagem compartilhada (HostGator / cPanel).

| URL | Página |
|---|---|
| `/` | Início |
| `/equipamentos-de-medicao` | Assistência Técnica: Equip. de Medição |
| `/calibracao` | Calibração |
| `/spectrum-medical` | Spectrum Medical |
| `/spectrum-medical/contrato` | Proposta para Contrato de Manutenção |
| `/locacao` | Locação |
| `/fale-conosco` | Fale Conosco |
| qualquer outra | Página 404 |

## Estrutura

```
index.php               roteia as URLs acima (e gera robots.txt e sitemap.xml)
enviar.php              recebe os formulários e envia por e-mail
router.php              só para o servidor local (php -S); a hospedagem usa o .htaccess
.htaccess               URLs amigáveis, bloqueios, cache e compressão (Apache)
.env.example            modelo das variáveis de ambiente (copie para .env)
app/
  config.php            ← links dos botões, títulos/descrições, logos, rodapé e formulários
  bootstrap.php         leitura do .env e funções auxiliares
  mailer.php            envio de e-mail (PHPMailer)
  views/layout/         cabeçalho e rodapé compartilhados
  views/pages/          conteúdo de cada página (textos do protótipo)
  views/partials/       modal do certificado CAL 0807
  vendor/phpmailer/     PHPMailer 7.1.1 (incluído, sem Composer)
  storage/              logs e e-mails de teste (não versionado)
assets/
  css/site.css          CSS do protótipo (+ ajustes comentados no fim)
  js/site.js            menu, modal, busca do catálogo, envio dos formulários
  img/                  fotos (WebP), logos, selo, certificado, ícones, imagem Open Graph
  docs/                 PDF do certificado CAL 0807
favicon.ico, apple-touch-icon.png
```

## Onde mudar o quê

- **Links dos botões "Solicite atendimento MINIPA" e "Emitir certificado"**: em `app/config.php`,
  bloco `links`. Troque `'PENDENTE'` pela URL. Enquanto estiver `PENDENTE`, o botão mostra o
  mesmo aviso do protótipo.
- **Destinatários de cada formulário**: em `app/config.php`, bloco `forms`, chave `para`.
- **Título e descrição (Google/compartilhamento)**: em `app/config.php`, bloco `paginas`.
- **Logo do cabeçalho e contatos do rodapé por página**: em `app/config.php`, chaves `logo` e `rodape`.
- **Textos das páginas**: em `app/views/pages/<pagina>.php`.
- **Contatos do rodapé**: em `app/views/layout/footer.php`.

## Rodar localmente (Windows)

1. Instale o PHP 8.x (só na primeira vez):
   ```powershell
   winget install PHP.PHP.8.3
   ```
   Feche e abra o terminal e confira com `php -v`. O XAMPP também serve.
2. Habilite as extensões no `php.ini` (o caminho aparece em `php --ini`). Se o arquivo não
   existir, copie `php.ini-development` para `php.ini` e descomente:
   ```ini
   extension=curl
   extension=mbstring
   extension=openssl
   ```
   Só para testar o captcha (Turnstile) no Windows: baixe https://curl.se/ca/cacert.pem e
   aponte `curl.cainfo` e `openssl.cafile` para ele. Na hospedagem isso já vem configurado.
3. Crie o `.env`:
   ```powershell
   copy .env.example .env
   ```
   Para testar sem enviar e-mails de verdade, deixe `MAIL_TRANSPORT=log`. Cada envio vira um
   arquivo `.eml` em `app/storage/emails/`, que abre no Outlook ou em qualquer leitor de e-mail.
4. Inicie o servidor na pasta do projeto:
   ```powershell
   php -S localhost:8000 router.php
   ```
   Depois acesse http://localhost:8000.

## Envio de e-mail

O formulário envia para `/enviar.php`. Esse arquivo:

1. descarta envios de robôs, com três verificações:
   - campo invisível (honeypot);
   - tempo mínimo de preenchimento, com token assinado;
   - limite de 5 envios a cada 10 minutos por IP.
2. confere o Cloudflare Turnstile, se as chaves estiverem no `.env`;
3. valida os campos obrigatórios e os formatos (e-mail, opções);
4. envia para os destinatários definidos em `app/config.php`, com o e-mail do cliente no
   "Responder para".

Com JavaScript, a resposta aparece na própria página, como no protótipo. Sem JavaScript, o
formulário também funciona e a página recarrega mostrando a mensagem.

| Formulário | Página | Destinatários |
|---|---|---|
| Multimarcas | Equip. de Medição | spectrumbh@spectrumbh.com.br |
| Solicitar Chamado Técnico | Spectrum Medical | sirlene@spectrumbh.com.br, claudio.teixeira@spectrumbh.com.br |
| Contrato de Manutenção | Spectrum Medical → Contrato | spectrumbh@spectrumbh.com.br |
| Orçamento de Locação | Locação | spectrumbh@spectrumbh.com.br |
| Fale Conosco | Fale Conosco | spectrumbh@spectrumbh.com.br |

### Configurar na HostGator

1. No cPanel, em **Contas de e-mail**, crie uma conta só para o site, por exemplo
   `site@spectrumbh.com.br`.
2. Em **Conectar dispositivos** (ou "Configurar cliente de e-mail"), anote o servidor de saída
   (SMTP). Normalmente é `mail.spectrumbh.com.br`, porta 465, SSL.
3. Preencha no `.env`:
   ```ini
   MAIL_TRANSPORT=smtp
   SMTP_HOST=mail.spectrumbh.com.br
   SMTP_PORT=465
   SMTP_SECURE=ssl
   SMTP_USER=site@spectrumbh.com.br
   SMTP_PASS=a-senha-da-conta
   MAIL_FROM=site@spectrumbh.com.br
   ```
4. Em **Email Deliverability** (Capacidade de entrega de e-mail), confira se SPF e DKIM estão
   "válidos". Sem isso, os e-mails podem cair no spam.
5. Para testar sem incomodar a equipe, preencha `MAIL_TEST_TO=seu-email@...`. Assim todos os
   formulários vão só para você, com os destinatários reais no assunto. Depois do teste,
   **deixe vazio**.
6. Se um envio falhar, o motivo fica em `app/storage/erros.log`. Se o SMTP não conectar, teste
   `MAIL_TRANSPORT=mail`, que usa a função `mail()` do próprio servidor.

> Se o e-mail `@spectrumbh.com.br` não estiver hospedado na HostGator (por exemplo, Google
> Workspace ou Microsoft 365), use os dados SMTP desse provedor. Confirme antes se a
> HostGator libera conexões SMTP de saída para ele: em hospedagem compartilhada isso costuma
> ser restrito.

### Captcha (Cloudflare Turnstile)

É gratuito e não exige mudar o DNS para a Cloudflare.

1. Em https://dash.cloudflare.com, abra **Turnstile** → **Add widget**, informe o domínio do
   site e escolha o modo **Managed**.
2. Copie a *Site Key* e a *Secret Key* para `TURNSTILE_SITE_KEY` e `TURNSTILE_SECRET_KEY` no `.env`.

Na maioria dos casos o captcha é invisível. Só quando a Cloudflare desconfia do visitante
aparece a caixa "Confirme que é humano" ao lado do botão de enviar. Com as chaves vazias, o
site usa só o honeypot, o tempo mínimo e o limite por IP.

## Hospedar na HostGator: checklist

1. **Versão do PHP**: no cPanel → *MultiPHP Manager*, escolha PHP 8.2 ou 8.3. O código
   também funciona no 7.4.
2. **Enviar os arquivos** para `public_html` pelo Gerenciador de Arquivos ou por FTP. Envie
   tudo, **exceto** `.git/`, `.env` e `spectrumprototipo_v33.html`. Os dois últimos estão
   bloqueados no `.htaccess`, mas é melhor não enviá-los.
3. **Criar o `.env` fora do `public_html`**: `/home/SEU_USUARIO/.env`. O site procura lá primeiro.
   - Preencha `SITE_URL` com o endereço final, sem barra no final.
   - Preencha `APP_SECRET` com um texto aleatório longo.
   - Preencha as variáveis de e-mail e do Turnstile.
4. **Permissão de escrita** em `app/storage/` (755 ou 775): é onde ficam o log de erros e o
   controle de limite de envios.
5. **SSL**: ative o AutoSSL ou Let's Encrypt no cPanel. Depois, descomente no `.htaccess` as
   duas linhas de "Força HTTPS".
6. **Testar**, com `MAIL_TEST_TO` preenchido:
   - as 7 páginas e uma URL inexistente (deve mostrar a 404);
   - os 5 formulários;
   - o modal do certificado e o botão "Baixar PDF".
7. **Opcional**: cadastrar o site no Google Search Console e enviar `/sitemap.xml`.

### O que ainda falta para publicar

- [ ] URLs reais dos botões "Solicite atendimento MINIPA", "Emitir certificado" (Spectrum
      Medical) e "Emitir certificado" (Calibração), em `app/config.php`.
- [ ] Conta de e-mail do site e senha SMTP, no `.env`.
- [ ] Domínio final, em `SITE_URL`. Hoje o padrão é `https://www.spectrumbh.com.br`.
- [ ] Chaves do Turnstile.
- [ ] Aprovação dos títulos e descrições das páginas (`app/config.php`) e da imagem de
      compartilhamento (`assets/img/og-spectrum.jpg`).

## Diferenças em relação ao protótipo

O layout foi comparado pixel a pixel com o protótipo nas 7 páginas, em desktop (1280 px) e
celular (390 px). Todas têm exatamente a mesma altura. As únicas diferenças (menos de 0,4% dos
pixels) vêm da recompressão das imagens e não são visíveis.

O que mudou de propósito:

- **Navegação**: os botões viraram links com URL própria. O "Início" flutuante também é um link.
- **Modo de renderização**: o protótipo não tinha `<!doctype>` e rodava em "modo quirks". O
  site usa o modo padrão e reproduz em CSS os três efeitos que alteravam o layout (comentados
  em `site.css`): margem abaixo dos formulários, altura das linhas da tabela de locação e altura
  do breadcrumb do contrato.
- **Formulários**:
  - nova caixa vermelha de erro, com as mensagens em `app/config.php` → `mensagens_erro`;
  - o widget do Turnstile pode aparecer ao lado do botão quando a Cloudflare pedir;
  - as mensagens de sucesso são as do protótipo.
- **Modal do certificado**: removi um `<iframe>` oculto que carregava o PDF sem exibi-lo. A
  imagem do certificado e o botão "Baixar PDF" continuam iguais.
- **Texto alternativo dos logos**: "Spectrum by Minipa" e "Spectrum Medical" nas páginas
  correspondentes. Antes era sempre "Spectrum".
- **Novos itens**:
  - página 404;
  - link "Pular para o conteúdo", visível só ao navegar pelo teclado;
  - títulos, descrições e Open Graph por página;
  - favicon;
  - robots.txt e sitemap.xml.
- **Imagens**:
  - fotos em WebP;
  - selo reduzido para 3× o tamanho exibido;
  - PDF idêntico ao original.

## Pontos do protótipo mantidos como estão (para decidir)

1. **Catálogos fora da margem**: em Spectrum Medical ("03 Catálogo de Manutenção") e em Locação
   ("02 Catálogo de Locação"), a seção está fora do container de conteúdo. Ela encosta nas
   bordas da tela, sem a margem lateral das outras seções. Parece um erro de marcação do
   protótipo; a correção é mover uma linha em cada arquivo.
2. **Chamado Técnico sem telefone nem e-mail**: o formulário da Spectrum Medical não pede
   nenhum dos dois, então a equipe não tem como responder diretamente.
3. **Rodapé e logo do Contrato**: no protótipo, a sub-página Contrato usa o logo padrão e mostra
   os dois contatos no rodapé. Mantive assim. Para seguir a regra da Spectrum Medical, troque
   `logo` e `rodape` dessa página em `app/config.php`.
4. **Texto de rascunho publicado**: em Spectrum Medical aparece "lista detalhada de tipos a
   complementar com a Spectrum", que parece uma anotação interna.
5. **Contraste de cores abaixo do recomendado** (WCAG AA pede 4,5:1 para texto pequeno):

   | Cor | Contraste | Onde aparece |
   |---|---|---|
   | Azul `#28A3DF` | 2,8:1 | eyebrows, "Clique e confira o certificado", tags, breadcrumb |
   | Laranja `#C97A2E` | 3,3:1 | "Saiba mais" de Calibração |
   | Verde `#0F8B7F` | 4,2:1 | inclusive texto branco nos botões verdes |

   As cores não foram alteradas.
6. **"O que você precisa?"** (Multimarcas) é opcional, como no protótipo (sem asterisco).
