<?php
/**
 * Envio de e-mail com PHPMailer. O transporte vem do .env (MAIL_TRANSPORT):
 *   smtp  envio autenticado (recomendado; padrão)
 *   mail  função mail() do PHP no servidor (alternativa, se o SMTP falhar)
 *   log   não envia; grava o e-mail em app/storage/emails/ (desenvolvimento)
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

require_once APP_DIR . '/vendor/phpmailer/Exception.php';
require_once APP_DIR . '/vendor/phpmailer/PHPMailer.php';
require_once APP_DIR . '/vendor/phpmailer/SMTP.php';

/**
 * @param string[]    $to
 * @param string|null $replyTo  e-mail de quem preencheu o formulário
 * @throws RuntimeException quando o envio falha
 */
function send_mail(array $to, $subject, $html, $text, $replyTo = null)
{
    $transport = strtolower(env('MAIL_TRANSPORT', 'smtp'));
    $from = env('MAIL_FROM', env('SMTP_USER'));
    if (!$from && $transport !== 'log') {
        throw new RuntimeException('MAIL_FROM/SMTP_USER não configurado no .env');
    }

    // Em testes, todos os e-mails vão para MAIL_TEST_TO em vez dos destinatários reais.
    if (env('MAIL_TEST_TO')) {
        $subject = '[TESTE → ' . implode(', ', $to) . '] ' . $subject;
        $to = array_map('trim', explode(',', env('MAIL_TEST_TO')));
    }

    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        if ($transport === 'smtp') {
            $mail->isSMTP();
            $mail->Host = env('SMTP_HOST');
            $mail->Port = (int) env('SMTP_PORT', '465');
            $secure = strtolower(env('SMTP_SECURE', 'ssl'));
            if ($secure === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($secure === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }
            $mail->SMTPAuth = env('SMTP_USER') !== '';
            $mail->Username = env('SMTP_USER');
            $mail->Password = env('SMTP_PASS');
            $mail->Timeout = 20;
        } elseif ($transport === 'mail') {
            $mail->isMail();
        }

        $mail->setFrom($from ?: 'site@localhost', env('MAIL_FROM_NAME', 'Site Spectrum'));
        foreach ($to as $address) {
            $mail->addAddress($address);
        }
        if ($replyTo) {
            $mail->addReplyTo($replyTo);
        }
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $html;
        $mail->AltBody = $text;

        if ($transport === 'log') {
            $mail->preSend();
            $dir = APP_DIR . '/storage/emails';
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            $file = $dir . '/' . date('Ymd-His') . '-' . substr(md5(uniqid('', true)), 0, 6) . '.eml';
            file_put_contents($file, $mail->getSentMIMEMessage());
            return;
        }

        $mail->send();
    } catch (MailerException $ex) {
        throw new RuntimeException($mail->ErrorInfo ?: $ex->getMessage(), 0, $ex);
    }
}

/** Monta o corpo (HTML e texto) com os campos preenchidos. */
function build_mail_body($formTitle, array $rows, $pagina)
{
    $html = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#000">'
        . '<p style="margin:0 0 12px"><strong>' . e($formTitle) . '</strong></p>'
        . '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;border:1px solid #DAE1E5">';
    $text = $formTitle . "\n" . str_repeat('-', 40) . "\n";
    foreach ($rows as $label => $value) {
        $shown = $value === '' ? '—' : $value;
        $html .= '<tr><td style="background:#F4F7F8;border:1px solid #DAE1E5;vertical-align:top;font-weight:bold;white-space:nowrap">'
            . e($label) . '</td><td style="border:1px solid #DAE1E5">' . nl2br(e($shown)) . '</td></tr>';
        $text .= $label . ': ' . $shown . "\n";
    }
    $footer = 'Enviado pelo formulário da página ' . absolute_url($pagina) . ' em ' . date('d/m/Y H:i') . '.';
    $html .= '</table><p style="color:#5B6770;font-size:12px;margin-top:16px">' . e($footer) . '</p></div>';
    $text .= "\n" . $footer . "\n";
    return [$html, $text];
}
