<?php

require __DIR__ . '/../vendor/autoload.php';

$router = new pedroac\routing\PathRouter\PatternRouter(
    new pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator
);
$router->map(
    'users',
    function () {
        echo "USERS\n";
    }
);
$router->map(
    'users/<user_id>',
    function ($vars) {
        echo "USER {$vars["user_id"]}\n";
    }
);
$router->map(
    'users/<user_id>/photos',
    function ($vars) {
        echo "USER {$vars["user_id"]} / PHOTOS";
    }
);
$router->map(
    'users/<user_id>/photos/<photo_id>',
    function ($vars) {
        echo "USER {$vars["user_id"]} / PHOTO / {$vars["photo_id"]}\n";
    }
);

$match = $router->match('users/pedroac/photos/123');
$match();
