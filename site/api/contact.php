<?php
/**
 * contact.php — self-hosted mail handler for the inquiry form.
 * Config is the block right below. No database, no dependencies.
 */

declare(strict_types=1);

const MAIL_TO      = 'info@pconestop.co.za';
const MAIL_FROM    = 'no-reply@pconestop.co.za';   // must be a domain mailbox for good deliverability
const MAIL_SUBJECT = 'Website inquiry';
const MIN_INTERVAL = 10;                            // seconds; ultra-simple rate limit per session

session_start();

$isFetch = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function respond(bool $ok, bool $isFetch): never
{
    if ($isFetch) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok]);
    } else {
        header('Location: /contact-us/?' . ($ok ? 'sent=1' : 'err=1') . '#contact-form');
    }
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    respond(false, $isFetch);
}

/* same-origin check (lenient: only rejects when a foreign origin is declared) */
$origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
if ($origin && !preg_match('~^https?://(www\.)?pconestop\.co\.za(/|$)~i', $origin)) {
    respond(false, $isFetch);
}

/* honeypot: bots fill it, humans never see it */
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    respond(true, $isFetch); /* pretend success, drop silently */
}

/* naive rate limit */
$now = time();
if (isset($_SESSION['last_mail']) && ($now - (int) $_SESSION['last_mail']) < MIN_INTERVAL) {
    respond(false, $isFetch);
}

$clean = static fn(string $k): string =>
    trim(str_replace(["\r", "\n", "%0a", "%0d"], ' ', (string) ($_POST[$k] ?? '')));

$name    = mb_substr($clean('name'), 0, 120);
$email   = mb_substr($clean('email'), 0, 160);
$phone   = mb_substr($clean('phone'), 0, 40);
$subject = mb_substr($clean('subject'), 0, 160);
$message = trim((string) ($_POST['message'] ?? ''));
$message = mb_substr($message, 0, 5000);

if ($name === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, $isFetch);
}

$body =
    "New inquiry from pconestop.co.za\n" .
    str_repeat('-', 40) . "\n" .
    "Name:    {$name}\n" .
    "Email:   {$email}\n" .
    "Phone:   " . ($phone !== '' ? $phone : '—') . "\n" .
    "Subject: {$subject}\n" .
    str_repeat('-', 40) . "\n\n" .
    $message . "\n\n" .
    str_repeat('-', 40) . "\n" .
    'Sent: ' . date('Y-m-d H:i:s') . ' | IP: ' . ($_SERVER['REMOTE_ADDR'] ?? '?') . "\n";

$headers = [
    'From: PC One Stop Website <' . MAIL_FROM . '>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PCOS-Web',
];

$sent = @mail(
    MAIL_TO,
    '=?UTF-8?B?' . base64_encode(MAIL_SUBJECT . ': ' . $subject) . '?=',
    $body,
    implode("\r\n", $headers)
);

if ($sent) {
    $_SESSION['last_mail'] = $now;
}

respond((bool) $sent, $isFetch);
