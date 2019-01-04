<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Resource\Interfaces
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/

namespace Resource\Interfaces;

use Slim\Container;

/**
 * StockDataAdapter to get Stocks from REST Service
 *
 * @category Stockscreener
 * @package  Resource\Interfaces
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class StockDataAdapter
{

    protected $container;
    protected $provider;
    protected $request;

    /**
     * Contructor with Container Injection
     *  
     * @param Container $container to inject
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->provider = $this->container->get('settings')['stockprovider'];
        $this->request = $this->container->get('settings')['stockrequest'];
    }

    /**
     * Get Stocks from API
     * 
     * @return mixed decoded JSONData
     */
    public function getStocks()
    {
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/api/stocks');
        return json_decode($response->getBody(), true);
    }

}
