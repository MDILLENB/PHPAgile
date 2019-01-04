<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */

namespace Business;

use Slim\Container;
use \Resource\Interfaces\StockDataImport;
use \Resource\Database\StockResource;
use \Resource\Database\ScoringResource;

/**
 * StockController connects Presentation with Business
 *
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class StockController
{

    protected $container;

    /**
     * Contructor with Container Injection
     * 
     * @param Container $container to inject container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get BasicData of Stock
     * 
     * @param string $ticker to get BasicData
     * 
     * @return Stock
     */
    function getBasics($ticker)
    {
        $stockResource = new StockResource($this->container);
        $stock = $stockResource->getBasics($ticker);
        return $stock;
    }

    /**
     * Get ScoringData of Stock
     * 
     * @param string $ticker to get ScoringData
     * 
     * @return array
     */
    function getScoringsbyTicker($ticker)
    {
        $scoringResource = new ScoringResource($this->container);
        $scorings = $scoringResource->getScoringsbyTicker($ticker);
        return $scorings;
    }

    /**
     * Get Stocks and generated Quotes & Indicators
     * 
     * @return Array
     */
    function getStocks()
    {
        $stockResource = new StockResource($this->container);
        $region = $this->container->get('settings')['country'];
        $stocks = $stockResource->getStocks($region);
        $stockdataarray = Array();
        foreach ($stocks as $stock) {
            $stockdata = new StockData();
            $stockdata->name = $stock->name;
            $stockdata->ticker = $stock->ticker;
            $stockdata->region = $region;
            $stockdata->industrygroup = $stock->industryGroup;
            $stockdata->region = $stock->region;
            $stockindicator = new \Business\StockIndicator();
            $stockindicator->generateStockIndicator();
            $stockdata->setIndicator($stockindicator);
            $stockquote = new \Business\StockQuote();
            $stockquote->generateStockQuote();
            $stockdata->setQuote($stockquote);
            array_push($stockdataarray, $stockdata);
        }
        return $stockdataarray;
    }

    /**
     * Update Stockdata
     * 
     * @return string
     */
    function postStocks()
    {
        $stockDataImport = new StockDataImport($this->container);
        $message = $stockDataImport->importStocks();
        return $message;
    }

}
