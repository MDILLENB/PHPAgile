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

/**
 * StockIndicator for Business Object StockData
 *
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class StockIndicator
{

    public $smaLongterm;
    public $rsiWeek;
    public $emaMonth;
    public $emaFiveMonth;
    public $performanceWeek;
    public $volatilityWeek;
    public $scoring;
    public $date;

    /**
     * Set IndicatorData
     * 
     * @param type $rsiWeek RelativeStrenghIndicator Scope Week
     * 
     * @return empty
     */
    public function setIndicatorRSI($rsiWeek)
    {
        $this->rsiWeek = $rsiWeek;
    }

    /**
     * Set IndicatorData
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
     * Set IndicatorData
     * 
     * @param type $performancWeek Performance Scope Week
     * 
     * @return empty
     */
    public function setPerformance($performancWeek)
    {
        $this->performanceWeek = $performancWeek;
    }

    /**
     * Set IndicatorData
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
     * Set Scoring based on Indicator
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
     * Generate random IndicatorData
     * 
     * @return $this
     */
    public function generateStockIndicator()
    {
        $this->rsiWeek = random_int(20, 90);
        $this->emaMonth = random_int(1, 100);
        $this->emaFiveMonth = random_int(1, 100);
        $this->smaLongterm = random_int(1, 100);
        $this->performanceWeek = random_int(-10, 10);
        $this->volatilityWeek = random_int(0, 5);
        $this->date = \Business\StockData::getToday();
        return $this;
    }

}
