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
 * StockData for Business Object Stock
 *
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class StockData
{

    /**
     * Name of Stock
     * 
     * @var string 
     */
    public $name;

    /**
     * Industrygroup of Stock
     * 
     * @var string 
     */
    public $industrygroup;

    /**
     * Ticker of Stock  
     * 
     * @var string 
     */
    public $ticker;

    /**
     * Region of Stock
     * 
     * @var string 
     */
    public $region;

    /**
     * StockQuote Data
     * 
     * @var StockQuote 
     */
    public $quote;

    /**
     * StockIndicator Data
     * 
     * @var StockIndicator
     */
    public $indicator;

    /**
     *  Set Stockdata without Quote and Indicator
     * 
     * @param type $name          coporate name of stock
     * @param type $industrygroup stock industrygroup, i.e. traveling
     * @param type $region        stock region, i.e. germany
     * @param type $ticker        stock ticker, i.e. XETR:MAN
     * 
     * @return empty
     */
    public function setStockData($name, $industrygroup, $region, $ticker)
    {
        $this->name = $name;
        $this->industrygroup = $industrygroup;
        $this->region = $region;
        $this->ticker = $ticker;
    }

    /**
     * Set StockIndicator
     * 
     * @param StockIndictor $stockindicator to be set     * 
     * 
     * @return empty
     */
    public function setIndicator($stockindicator)
    {
        $this->indicator = $stockindicator;
    }

    /**
     * Get StockIndicator
     * 
     * @return Stockindicator to get
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Set StockQuote
     * 
     * @param Stockquote $stockquote to set
     * 
     * @return empty
     */
    public function setQuote($stockquote)
    {
        $this->quote = $stockquote;
    }

    /**
     * Get StockQuote
     * 
     * @return StockQuote to get
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Get Current Date for today
     * 
     * @return Date $today with current Date
     */
    public static function getToday()
    {
        date_default_timezone_set("Europe/Berlin");
        $today = date_create(date("Y-m-d H:i:s"));
        return $today;
    }

}
