<?php
// Load composer
require __DIR__ . '/../vendor/autoload.php';


use Linkita\BasicBot\MimimiBot;

$bot_api_key  = 'Your Token';
$bot_username = 'BliblibliBot';

// Create Telegram API object
$telegram = new Telegram($bot_api_key);

$bot = new MimimiBot($telegram);
$bot->run();

