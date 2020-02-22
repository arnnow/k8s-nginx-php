<?php
/* OO API */
$memcache_obj = new Memcached;
/* connect to memcached server */
$memcache_obj->addServer(getenv('MEMCACHED_SERVICE_HOST'), getenv('MEMCACHED_SERVICE_PORT'));

function getRandomWord($len = 10) {
    $word = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

/*
set value of item with key 'var_key', using on-the-fly compression
expire time is 50 seconds
*/
$key = getRandomWord();
$memcache_obj->set($key, getRandomWord(), 50);
echo $memcache_obj->get($key);

?>
