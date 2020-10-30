<?php

/* Autoloading classes */
function __autoload($class_name) {
    include "classes/" . $class_name . ".class.php";
}

?>