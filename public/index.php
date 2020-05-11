<?php
/**
 *
 */


use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
 * Set autoload and make application root directory accessible
 */
require_once '../base.php';

$dotenv = Dotenv::createImmutable( dirname(__DIR__));
$dotenv->load();

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