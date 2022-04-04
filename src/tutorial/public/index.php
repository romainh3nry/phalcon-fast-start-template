<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;



// Inscription du chargeur automatique
$loader = new Loader();

$loader->registerDirs(
    [
        "../app/controllers/",
        "../app/models/",
    ]
);

$loader->register();



// Création du DI
$di = new FactoryDefault();

// Configuration du composant vue
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir("../app/views/");

        return $view;
    }
);

// Définition d'une URI de base afin que les URIs générées incluent le dossier "tutorial"
$di->set(
    "url",
    function () {
        $url = new UrlProvider();

        $url->setBaseUri("/tutorial/");

        return $url;
    }
);



$application = new Application($di);

try {
    // Gestion de la requête
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}
