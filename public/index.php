<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../vendor/autoload.php";


$dotenv = Dotenv::createImmutable( dirname(__DIR__));
$dotenv->load();

/*
 * Eloquent set up for application wide access
 */
$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => getenv("DB_DRIVER"),
    'host'      => getenv("DB_HOST"),
    'database'  => getenv("DB_DATABASE"),
    'username'  => getenv("DB_USERNAME"),
    'password'  => getenv("DB_PASSWORD"),
    'charset'   => getenv("DB_CHARSET"),
    'collation' => getenv("DB_COLLATION"),
]);
$capsule->bootEloquent();
$capsule->setAsGlobal();

require_once  '../config/router.php';