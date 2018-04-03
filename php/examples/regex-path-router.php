<?php

require __DIR__ . '/../vendor/autoload.php';

$router = new pedroac\routing\PathRouter\RegexRouter;
$router->map(
    '~^users/?$~',
    function () {
        echo "USERS\n";
    }
);
$router->map(
    '~^users/(\w+)/?$~',
    function (array $matches) {
        echo "USER: {$matches[0]}\n";
    }
);

$match = $router->match('users/pedroac');
$match();
