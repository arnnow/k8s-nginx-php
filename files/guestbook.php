<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['cmd']) === true) {

  $redis = new Redis();
  $sentinel_host=getenv('REDIS_SENTINEL_SERVICE_HOST');
  $sentinel_port=getenv('REDIS_SENTINEL_SERVICE_PORT');

  $sentinel = new RedisSentinel($sentinel_host,$sentinel_port);

  $master = $sentinel->getMasterAddrByName('mymaster');

  header('Content-Type: application/json');

  if ($_GET['cmd'] == 'set') {
    $redis->connect($master[0],$master[1]);
    $redis->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $redis->connect(getenv('REDIS_SERVICE_HOST'),getenv('REDIS_SERVICE_PORT'));

    $value = $redis->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>
