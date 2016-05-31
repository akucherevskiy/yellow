<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 15.05.16
 * Time: 15:07
 */

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => array(
            // raw password is foo
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);
$app->register(new Silex\Provider\SecurityServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'      => $url["host"],
        'dbname'    => substr($url["path"], 1),
        'user'      =>  $url["user"],
        'password'  =>  $url["pass"],
        'charset'   => 'utf8mb4',
    ),
));

$app->boot();

