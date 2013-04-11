<?php
spl_autoload_register(function ($className) {
    $className = preg_replace('/^Naf\\\\/', '', $className);
    $path = str_replace('\\', '/', $className);
    if (is_readable(dirname(__FILE__) . "/$path.php")) {
        include dirname(__FILE__) . "/$path.php";
    }
});
?>
