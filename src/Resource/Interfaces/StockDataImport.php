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
 * StockDataImport imports StockData from external interface
 *
 * @category Stockscreener
 * @package  Resource\Interfaces
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class StockDataImport
{

    protected $container;
  
    /**
     * Standard Contructor with injection of container
     * 
     * @param Container $container to inject
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Import Stocks using Adapter and Parser
     * 
     * @return string 
     */
    public function importStocks()
    {
        $this->container->get('logger')->notice("import Stocks");
        $client = new StockDataAdapter($this->container);
        $parser = new StockDataParser($this->container);
        $engine = new \Business\StockAnalyseEngine($this->container);
        $stockResource = new \Resource\Database\StockResource($this->container);
        $json = $client->getStocks();
        $today = \Business\StockData::getToday();
        $importstocks = array();
        foreach ($json as $item) {
            $stockdata = $parser->parseStockdata($item, $today);
            $scoring = $engine->setStockScoring(
                $stockdata->getIndicator(), $stockdata->getQuote()
            );
            $stockdata->getIndicator()->setScoring($scoring);
            array_push($importstocks, $stockdata);
        }
        $message = $stockResource->persistStocks($importstocks);
        return $message;
    }

}
