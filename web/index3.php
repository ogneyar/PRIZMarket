<?php
include_once '../vendor/autoload.php';
include_once 'a_conect.php';

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include_once 'madeline.php';

$MP = new \danog\MadelineProto\API('session.madeline');
$MP->start();

$me = $MP->get_self();
$MP->logger($me);
$me = print_r($me, true);
$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => $me]);


/*
use MemCachier\MemcacheSASL;

// Create client
$m = new MemcacheSASL();
$servers = explode(",", getenv("MEMCACHIER_SERVERS"));
foreach ($servers as $s) {
    $parts = explode(":", $s);
    $m->addServer($parts[0], $parts[1]);
}

// Setup authentication
$m->setSaslAuthData( getenv("MEMCACHIER_USERNAME")
                   , getenv("MEMCACHIER_PASSWORD") );

// Test client
$m->add("foo", "bar");
echo $m->get("foo");

*/



include_once 'NaHerokuBot.php';
include_once 'TesterBotoffBot.php';
?>