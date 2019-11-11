<?php

/*
 *   Date: 2017-18-01
 * Author: Dawid Yerginyan
 */
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once __DIR__ . '/core/config/functions.php';
require __DIR__ . '/core/app.php';

$app = new App();

$app->autoload();

$app->config();

$app->start();

?>