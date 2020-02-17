<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Predis/Autoloader.php';

Predis\Autoloader::register();

if (isset($_GET['cmd']) === true) {
  $sentinel_host=getenv('REDIS_SENTINEL_SERVICE_HOST');
  $sentinel_port=getenv('REDIS_SENTINEL_SERVICE_HOST');
  $sentinel = new RedisSentinel($sentinel_host,$sentinel_port);

  if (getenv('GET_HOSTS_FROM') == 'env') {
    $host = $sentinel->getMasterAddrByName('mymaster');
  }
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host[0],
      'port'   => $host[1],
    ]);

    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $host = 'redis';
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host,
      'port'   => 6379,
    ]);

    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>
