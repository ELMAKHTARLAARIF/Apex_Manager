<?php
spl_autoload_register(function ($class) {

    $folders = [

        __DIR__ . '/src/Core/',
        __DIR__ . '/src/Entity/',
        __DIR__ . '/src/Repositories/',
        __DIR__ . '/src/Service/',
        __DIR__ . '/src/Core/Helpers/',
        __DIR__ . '/src/Core/Finance/',
        __DIR__ . '/src/Core/Database/',


    ];

    foreach ($folders as $folder) {
        $file = $folder . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
