<?php

// You need to replace the host value (localhost here) with the database host
// And the dbname value (your-database-name) with your database name
define('DB_DSN', 'mysql:host=localhost;dbname=your-database-name');

// You need to replace username with the user name of the database
define('DB_USER', 'username');

// You need to replace userpass with the user password of the database
define('DB_PASS', 'userpass');

// You don't need to change anything here : this array is for PDO options
define('DB_OPTIONS', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// You need to replace mail.domain.ext with your mail host
define('MAIL_HOST', 'mail.domain.ext');

// You need to replace 000 with your mail port
define('MAIL_PORT', 000);

// You need to replace mailfrom@domain.ext with the email address for sending
define('MAIL_FROM', 'mailfrom@domain.ext');

// You need to replace mailpass with your email address password for sending
define('MAIL_PASSWORD', 'mailpass');

// You need to replace mailto@domain.ext with your email address for receiving
define('MAIL_TO', 'mailto@domain.ext');

// You need to replace mailusername with your name
define('MAIL_USERNAME', 'mailusername');

// You need to replace your-backend-site-key with your Google ReCaptcha backend site key
define('RECAPTCHA_TOKEN', 'your-backend-site-key');

// Then remove the '-example' from 'parameters-example.php' to get 'parameters.php'
