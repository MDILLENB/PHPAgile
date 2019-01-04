<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'mode' => 'prod',
        'stockprovider' => 'http://localhost/api/stocks',
        'stockrequest' => '',
        'country' => 'germany',
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::NOTICE,
            'path' => '/logs/app.log',
        ],        
	'stockconfig' => [
            'RSIMax' => 70,
            'RSIHigh' => 60,
            'RSIMedium' => 50,
            'RSILow' => 40,
            'RSILower' => 30,
            'RSIMin' => 20,
            'VolaMedium' => 2,
            'VolaLow' => 1,            
        ],        
    ],
    'doctrine' => [
        'meta' => [ 
            'entity_path' => [
            'app/Entity'
             ],
            'auto_generate_proxies' => true,
            'proxy_dir' =>  __DIR__.'/../cache/proxies',
            'cache' => null,
        ],
        'connection' => [
            'driver'   => 'pdo_mysql',
            'host'     => 'localhost',
            'dbname'   => 'stockscreener',
            'user'     => 'admin',
            'password' => '',
        ]
    ]    
    
];
