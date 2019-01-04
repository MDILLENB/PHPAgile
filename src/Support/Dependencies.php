<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/

namespace Support;
use Business\StockController;
use Business\StockData;
use Slim\Container;

/**
 * Dependencies registers all Dependencies in container
 *
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class Dependencies
{

    protected $container;

    /**
     * Contructor with injection of container
     * 
     * @param Container $container to inject
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register StockController
     * 
     * @return StockController StockData
     */
    public function registerStockController()
    {
        $this->container['StockController'] = function ($container) 
        {
            return new StockController($container);
        };        
    }
    
    /**
     * Register Business Classes
     * 
     * @return StockController StockData
     */
    public function registerStockData()
    {
        $this->container['StockData'] = function ($container) 
        {
            return new StockData($container);
        };
    }

    /**
     * Register Logger based on Monolog
     * 
     * @return \Monolog\Logger
     */
    function registerLogger()
    {
        $this->container['logger'] = function ($config)
        {
            $log = $config['settings']['logger'];
            $logger = new \Monolog\Logger($log['name']);
            $fileHandler = new \Monolog\Handler\StreamHandler(
                $log['path'], $log['level']
            );
            $logger->pushHandler($fileHandler);
            return $logger;
        };
    }

    /**
     * Register configData
     * 
     * @return Config 
     */
    function registerConfig()
    {
        $this->container['mode'] = function ($config) 
        {
            $mode = $config['settings']['mode'];
            return $mode;
        };

        $this->container['stockconfig'] = function ($config) 
        {
            $stockconfig = $config['settings']['stockconfig'];
            return $stockconfig;
        };

        $this->container['country'] = function ($config) 
        {
            $country = $config['settings']['country'];
            return $country;
        };
    }

    /**
     * Register Database Config
     * 
     * @return array
     */
    function registerDatabase()
    {
        $this->container['database'] = function ($config) 
        {
            $database = $config['doctrine']['connection'];
            $connectionOptions = array(
                'driver' => $database['driver'],
                'host' => $database['host'],
                'dbname' => $database['dbname'],
                'user' => $database['user'],
                'password' => $database['password']
            );
            return $connectionOptions;
        };
    }

}
