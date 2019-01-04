<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 */

namespace Resource\Database;

use Doctrine\ORM\Mapping;

/**
 * Entity to store Stock
 * 
 * @Entity
 * @Table(name="scoring")
 * @category             Stockscreener
 * @package              Resource\Database
 * @author               Marco Dillenburg <mail@marcodillenburg.de>
 * @license              MIT License
 * @link                 www.marcodillenburg.de
 */
class Scoring
{
    /**
     * Identifier
     * 
     * @var integer
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $identifier;

    /**
     * Stock Ticker
     * 
     * @var string
     * @Column(type="string", length=64)
     */
    public $ticker;

    /**
     * Stochastic Moving Average 200 days
     * 
     * @var float
     * @Column(type="float", length=5,name="sma200")
     */
    public $smaLongterm;

    /**
     * Lowest Quote of Month
     * 
     * @var float
     * @Column(type="float", length=5, name="low1m")
     */
    public $lowMonth;

    /**
     * Highest Close of Month
     * 
     * @var float
     * @Column(type="float", length=5, name="high1m")
     */
    public $highMonth;

    /**
     * Volatility of week
     * 
     * @var float
     * @Column(type="float", length=5)
     */
    public $volatilityWeek;

    /**
     * Current Date
     * 
     * @var date
     * @Column(type="datetime")
     */
    public $date;

    /**
     * Performance of Week
     * 
     * @var string
     * @Column(type="float", length=10, name="perfw")
     */
    public $perfWeek;

    /**
     * Releativ Strenth index of Week
     * 
     * @var float
     * @Column(type="float", length=5, name="rsi1w")
     */
    public $rsiWeek;

    /**
     * Close Quote
     * 
     * @var float
     * @Column(type="float", length=5)
     */
    public $close;

    /**
     * Analysed Scoring
     * 
     * @var integer
     * @Column(type="integer", length=5)
     */
    public $scoring;

    /**
     * Exponentiell Moving Average of Month
     * 
     * @var float
     * @Column(type="float", length=5, name="ema20")
     */
    public $emaMonth;

    /**
     * Exponentiell Moving Average of 5 Month
     * 
     * @var float
     * @Column(type="float", length=5, name="ema100")
     */
    public $emaFiveMonth;
    
    /**
     * Get Identifier
     * 
     * @return int $identifier
     */
    function getIdentifier() 
    {
        return $this->identifier;
    }
    
    /**
     * Get Ticker
     * 
     * @return String $ticker
     */
    function getTicker() 
    {
        return $this->ticker;
    }
    
    /**
     * Set ScoringData
     * 
     * @param type $rsiW RelativeStrenghIndicator Scope Week
     * 
     * @return empty
     */
    public function setIndicatorRSI($rsiW)
    {
        $this->rsiWeek = $rsiW;
    }
    
    /**
     * Set ScoringData
     * 
     * @param type $emaMonth     Exponential Moving Average Scope Month
     * @param type $emaFiveMonth Exponential Moving Average Scope 5 Month
     * @param type $smaLongterm  stochastc Moving Average Scope Year

     * @return empty
     */
    public function setMovingAverage($emaMonth, $emaFiveMonth, $smaLongterm)
    {
        $this->emaMonth = $emaMonth;
        $this->emaFiveMonth = $emaFiveMonth;
        $this->smaLongterm = $smaLongterm;
    }
    
    /**
     * Set ScoringData
     * 
     * @param type $perfw Performance Scope Week
     * 
     * @return empty
     */
    public function setPerformance($perfw)
    {
        $this->perfWeek = $perfw;
    }

    /**
     * Set ScoringData
     *      
     * @param int $volatilityWeek Volatility Scope Week
     * 
     * @return empty
     */
    public function setVolatility($volatilityWeek)
    {
        $this->volatilityWeek = $volatilityWeek;
    }
    
    /**
     * Set Scoring based on Analyse
     * 
     * @param int $scoring wit analysed scoring
     * 
     * @return empty
     */
    public function setScoring($scoring)
    {
        $this->scoring = $scoring;
    }
    
    /**
     * Set Scoring StockQuotes
     * 
     * @param type $date      Quote Date
     * @param type $close     Close Quote
     * @param type $lowMonth  lowest Quote of Month
     * @param type $highMonth highest Quote of Month
     * 
     * @return empty
     */
    public function setQuote($date, $close, $lowMonth, $highMonth)
    {
        $this->date = $date;
        $this->close = $close;
        $this->lowMonth = $lowMonth;
        $this->highMonth = $highMonth;
    }


}
