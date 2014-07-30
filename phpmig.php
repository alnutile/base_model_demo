<?php

require_once __DIR__.'/vendor/autoload.php';
use \Phpmig\Adapter,
    \Pimple\Container as Pimple,
    \Phpmig\Adapter\Illuminate\Database as PhpMigIlluminate;
use Illuminate\Database\Capsule\Manager as Capsule;
$container = new Pimple();
$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

$capsule = new \Illuminate\Database\Capsule\Manager();

$container['config'] = array(
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/local.sqlite',
    'prefix' => ''
);

$container['db'] = function($c){
    $capsule = new Capsule();
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    return $capsule;
};

$container['schema'] = function($c){
    /* Bootstrap Eloquent */
    $capsule = new Capsule();
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    return $capsule->schema();
};

$container['phpmig.adapter'] = function($c) use ($container) {
    return new PhpMigIlluminate($c['db'], 'migrations');
};

// You can also provide an array of migration files
// $container['phpmig.migrations'] = array_merge(
//     glob('migrations_1/*.php'),
//     glob('migrations_2/*.php')
// );

return $container;