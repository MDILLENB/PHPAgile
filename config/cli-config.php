  ,.<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$devMode = true;
$path = array('stockscreener/Resource/Database');
     

$config = Setup::createAnnotationMetadataConfiguration($path, $devMode);
$settings = require '../config/settings.php';
        
$db = $settings['doctrine']['connection'];
         
$connectionOptions = array(
            'driver'   => $db['driver'],
            'host'     => $db['host'],
            'dbname'   => $db['dbname'],
            'user'     => $db['user'],
            'password' => $db['password']
);

$entityManager =       EntityManager::create($connectionOptions, $config);

return ConsoleRunner::createHelperSet($entityManager);
