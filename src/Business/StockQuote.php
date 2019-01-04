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
 * StockQuotes for Business Object StockData
 *
 * @category Stockscreener
 * @package  Business
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class StockQuote
{

    public $close;
    public $highMonth;
    public $lowMonth;
    public $date;

    /**
     * Set StockQuotes
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

    /**
     * Generate random StockQuote
     * 
     * @return \Business\StockQuote
     */
    public function generateStockQuote()
    {
        $this->close = random_int(1, 100);
        $this->highMonth = $this->close + random_int(0, 5);
        $this->lowMonth = $this->close - random_int(0, 5);
        $this->date = \Business\StockData::getToday();
        return $this;
    }

}
