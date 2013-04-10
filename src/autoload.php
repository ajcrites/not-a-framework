<?php
spl_autoload_register(function ($className) {
    $path = str_replace('\\', '/', $className);
    if (is_readable(dirname(__FILE__) . "/$path.php")) {
        include dirname(__FILE__) . "/$path.php";
    }
    else {
        die('not read');
    }
});
?>
