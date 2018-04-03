<?php

require __DIR__ . '/../vendor/autoload.php';

$router = new pedroac\routing\PathRouter\HashRouter;
$router->map(
    'home',
    function () {
        echo "HOME\n";
    }
);
$router->map(
    'about-us',
    function () {
        echo "ABOUT US\n";
    }
);

$match = $router->match('about-us');
$match();