<?php

use DbConsole\DbConsole\DbConsole;

$services->add('dbconsole', function($app){
    $dbconsole = new DbConsole($app);
    return $dbconsole;
});

