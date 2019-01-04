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

/**
 * StockAnalyse Engine calculates score of Stock
 *
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class StockAnalyseEngine
{

    /**
     * Container injected  
     * 
     * @var Slim\Container
     */
    protected $container;

    /**
     * Maximum relative strength index
     *
     * @var float
     */
    public $rsiMax;

    /**
     * High relative strength index
     * 
     * @var float
     */
    public $rsiHigh;

    /**
     * Medium relative strength index
     * 
     * @var float
     */
    public $rsiMedium;

    /**
     * Low relative strength index
     * 
     * @var float
     */
    public $rsiLow;

    /**
     * Lower relative strength index
     * 
     * @var float
     */
    public $rsiLower;

    /**
     * Minimum relative strength index
     * 
     * @var float
     */
    public $rsiMin;

    /**
     * Medium Volatility
     * 
     * @var float
     */
    public $volaMedium;

    /**
     * Low Volatility
     * 
     * @var float
     */
    public $volaLow;

    /**
     * Contructor with Container Injection
     *        
     * @param Container $container to get Config
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->rsiMax = $this->container->get('stockconfig')['RSIMax'];
        $this->rsiHigh = $this->container->get('stockconfig')['RSIHigh'];
        $this->rsiMedium = $this->container->get('stockconfig')['RSIMedium'];
        $this->rsiLow = $this->container->get('stockconfig')['RSILow'];
        $this->rsiLower = $this->container->get('stockconfig')['RSILower'];
        $this->rsiMin = $this->container->get('stockconfig')['RSIMin'];
        $this->volaLow = $this->container->get('stockconfig')['VolaLow'];
        $this->volaMedium = $this->container->get('stockconfig')['VolaMedium'];
    }

    /**
     * Setting Stock Scoring Value     *  
     * 
     * @param StockIndicator $stockindicator to analyse scoring with indicators
     * @param StockQuote     $stockquote     to analyse scoring with quote
     * 
     * @return float $score analyse result
     */
    public function setStockScoring($stockindicator, $stockquote)
    {
        $score = 0;
        if ($stockindicator->performanceWeek < 0 
            || $stockindicator->volatilityWeek >= 2 
            || $stockindicator->rsiWeek < $this->rsiLower
        ) {
            $score = -1; // KO by low perf,high vol or low rsi
        } else {

            $score += $this->setRSIStockFactor($stockindicator);
            $score += $this->setIndicatorEMAFactor($stockindicator, $stockquote);
            $score += $this->setIndicatorVolatiliyFactor($stockindicator);
        }
        return $score;
    }

    /**
     * Setting RSI Factor Value for Scoring     
     *  
     * @param StockIndicator $stockindicator to analyse RSI Indicator 
     * 
     * @return float $score analysed scoring focussed on rsi
     */
    function setRSIStockFactor($stockindicator)
    {
        $score = 0;
        $rsi = $stockindicator->rsiWeek;
        if ($rsi > $this->rsiHigh) {
            $score += 1;
        }
        if ($rsi > $this->rsiMedium) {
            $score += 1;
        }
        if ($rsi > $this->rsiLow) {
            $score += 1;
        }
        if ($rsi > $this->rsiLower) {
            $score += 1;
        }
        return $score;
    }

    /**
     * Calculate Score based on EMA and Close
     * 
     * @param StockIndicator $stockindicator to analyse EMA Indicator 
     * @param StockQuote     $stockquote     to analyse Close Quote
     * 
     * @return int
     */
    function setIndicatorEMAFactor($stockindicator, $stockquote)
    {
        $score = 0;
        if ($stockindicator->emaMonth > $stockindicator->emaFiveMonth) {
            $score += 1;
        }
        if ($stockquote->close > $stockindicator->emaMonth) {
            $score += 1;
        }
        return $score;
    }

    /**
     * Calculate Score based on Volatility
     * 
     * @param StockIndicator $stockindicator to analyse Volatility
     * 
     * @return int
     */
    function setIndicatorVolatiliyFactor($stockindicator)
    {
        $score = 0;
        if ($stockindicator->volatilityWeek < ($this->volaMedium * 0.5)) {
            $score += 2;
        }
        if ($stockindicator->volatilityWeek < ($this->volaLow * 0.5)) {
            $score += 2;
        }
        return $score;
    }

}
