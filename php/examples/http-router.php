<?php

require __DIR__ . '/../vendor/autoload.php';

$router = new pedroac\routing\HttpRouter(
    new pedroac\routing\PathRouter\PatternRouter(
        new pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator
    )
);
$router->map(
    'GET', 'users',
    function () {
        echo "USERS\n";
    }
);
$router->map(
    'POST', 'users',
    function () {
        echo "USERS\n";
    }
);
$router->map(
    'GET', 'users/<user_id>',
    function ($vars) {
        echo "USER {$vars["user_id"]}\n";
    }
);
$router->map(
    'PUT', 'users/<user_id>',
    function ($vars) {
        echo "USER {$vars["user_id"]}\n";
    }
);

$match = $router->match('PUT', 'users/pedroac');
$match();