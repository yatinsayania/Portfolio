<?php

/* =====================================================
   YATIN SAYANIA PORTFOLIO CONTACT FORM
   Production Version
===================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit();
}

/* =====================================================
   HONEYPOT SPAM PROTECTION
===================================================== */

if (!empty($_POST['website'])) {
    exit();
}

/* =====================================================
   INPUT SANITIZATION
===================================================== */

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

/* =====================================================
   VALIDATION
===================================================== */

if (
    empty($name) ||
    empty($email) ||
    empty($message)
) {

    die("Required fields are missing.");

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Invalid email address.");

}

/* =====================================================
   PREVENT HEADER INJECTION
===================================================== */

$name = str_replace(
    array("\r", "\n"),
    '',
    htmlspecialchars($name)
);

$email = str_replace(
    array("\r", "\n"),
    '',
    htmlspecialchars($email)
);

$subject = htmlspecialchars($subject);
$message = htmlspecialchars($message);

/* =====================================================
   EMAIL SETTINGS
===================================================== */

$to = "support@cyberbrd.dpdns.org";

$mail_subject =
"Portfolio Contact Form";

if (!empty($subject)) {

    $mail_subject .=
    " | " . $subject;

}

/* =====================================================
   EMAIL BODY
===================================================== */

$mail_body =

"=================================================\n".
"NEW WEBSITE CONTACT REQUEST\n".
"=================================================\n\n".

"Name: ".$name."\n\n".

"Email: ".$email."\n\n".

"Subject: ".$subject."\n\n".

"Message:\n\n".$message."\n\n".

"=================================================\n".
"Submitted From:\n".
$_SERVER['REMOTE_ADDR']."\n".
date("Y-m-d H:i:s")."\n".
"=================================================\n";

/* =====================================================
   EMAIL HEADERS
===================================================== */

$headers =
"From: Website Contact <support@cyberbrd.dpdns.org>\r\n";

$headers .=
"Reply-To: ".$email."\r\n";

$headers .=
"MIME-Version: 1.0\r\n";

$headers .=
"Content-Type: text/plain; charset=UTF-8\r\n";

/* =====================================================
   SEND EMAIL
===================================================== */

$mail_sent = mail(
    $to,
    $mail_subject,
    $mail_body,
    $headers
);

/* =====================================================
   SUCCESS
===================================================== */

if ($mail_sent) {

    header("Location: thankyou.html");
    exit();

}

/* =====================================================
   FAILURE
===================================================== */

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Message Failed
</title>

<style>

body{
font-family:Arial,sans-serif;
background:#0f172a;
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
text-align:center;
padding:20px;
}

.card{
max-width:600px;
padding:40px;
background:#1e293b;
border-radius:20px;
}

a{
color:#60a5fa;
text-decoration:none;
}

</style>

</head>

<body>

<div class="card">

<h1>
Message Not Sent
</h1>

<p>

Unfortunately the email could not be delivered.

Please contact me directly at:

</p>

<p>

<strong>
support@cyberbrd.dpdns.org
</strong>

</p>

<p>

<a href="index.html">

Return To Homepage

</a>

</p>

</div>

</body>

</html>
