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
 * StockDataParser parses Data of StockdataAdapter
 *
 * @category Stockscreener
 * @package  Resource\Interfaces
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class StockDataParser
{

    protected $container;

    /**
     * Constructor to inject container
     * 
     * @param Container $container to inject
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Parse Stockdata from Adapter
     * 
     * @param mixed $item  Data to parse
     * @param Date  $today current Date
     * 
     * @return \Business\StockData
     */
    function parseStockdata($item, $today)
    {
        $this->container->get('logger')->info("parse Stockdata");
        $stockdata = new \Business\StockData();
        $stockdata->setStockData(
            $item['name'], $item['industrygroup'], $item['region'], 
            $item['ticker']
        );
        $stockindicator = new \Business\StockIndicator();
        $stockindicator->setIndicatorRSI($item['indicator']['rsiWeek']);
        $stockindicator->setMovingAverage(
            $item['indicator']['emaMonth'], 
            $item['indicator']['emaFiveMonth'], 
            $item['indicator']['smaLongterm']
        );
        $stockindicator->setPerformance($item['indicator']['performanceWeek']);
        $stockindicator->setVolatility($item['indicator']['volatilityWeek']);
        $stockdata->setIndicator($stockindicator);
        $stockquote = new \Business\StockQuote();
        $stockquote->setQuote(
            $today, $item['quote']['close'], 
            $item['quote']['highMonth'], 
            $item['quote']['lowMonth']
        );
        $stockdata->setQuote($stockquote);
        return $stockdata;
    }

}
