<?php
// Set error reporting pretty high
error_reporting(E_ALL | E_STRICT);
// get autoload to resolve dependencies
$loader = require '../vendor/autoload.php';
1.1 Composer.json
{
    "name": "finanzmarktportal",
    "description": "Finanzmarktportl mit Informationsbereitstellung und Handelswerkzeug.",
    "authors": [
        {
            "name": "Marco Dillenburg",
            "email": "info@crowdlogistix.com"
        }
    ],    
    "require": { "phpunit/phpunit-skeleton-generator": "*"},
    "autoload": { 
        "classmap": ["src/"]
    } 
}
