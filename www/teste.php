<?php



//var_dump(opcache_get_status()); 
/*
var_dump(apc_bin_dump()); 
echo '<br/>';
var_dump(apc_cache_info()); 
exit();
 * */

$m = new Memcached();
$m->addServer('localhost', '123456');


memcache_add('oiiii:',  1, 'valor de oi');



echo phpinfo(); exit() ;