<?php
namespace Test;

use Business\StockAnalyseEngine;
use Business\StockData;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-12-14 at 02:07:05.
 */
class StockAnalyseEngineTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var StockAnalyseEngine
     */
    protected $object;
    protected $ci;  
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {      
        $settings = require __DIR__ . '/../../config/settings.php';
        $container = new \Slim\Container($settings);
        $container['stockconfig'] = function ($config) {
             $stockconfig =$config['settings']['stockconfig'];  
             return $stockconfig;
        };
        $this->object = new StockAnalyseEngine($container);
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Business\StockAnalyseEngine::setStockScoring
     * 
     */
    public function testSetStockScoringConfig()
    {       
        $this->assertEquals(70,$this->object->rsiMax);
       
    }
    
     /**
     * @covers Business\StockAnalyseEngine::setStockScoring
     * 
     */
    public function testSetStockScoringKO()
    {        
        $today = \Business\StockData::getToday();
        $stockindicator = new \Business\StockIndicator(); 
        $stockindicator->setIndicatorRSI(50);
        $stockindicator->setMovingAverage(2,1,1);
        $stockindicator->setPerformance(-1);     
        $stockindicator->setVolatility(1);    
        $stockquote = new \Business\StockQuote();
        $stockquote->setQuote($today, 2, 1, 2);
        $score = $this->object->setStockScoring($stockindicator, $stockquote);
        $this->assertEquals(-1,$score);
       
    }
    
    /**
     * @covers Business\StockAnalyseEngine::setStockScoring
     * 
     */
    public function testSetStockScoringLow()
    {
        $today = \Business\StockData::getToday();
        $stockindicator = new \Business\StockIndicator;  
        $stockindicator->setIndicatorRSI(50);
        $stockindicator->setMovingAverage(2,1,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(1);  
        $stockquote = new \Business\StockQuote;
        $stockquote->setQuote($today, 2, 1, 2);
        $score = $this->object->setStockScoring($stockindicator, $stockquote);
        $this->assertEquals(3,$score);
     
    }
    
    /**
     * @covers Business\StockAnalyseEngine::setStockScoring
     * 
     */
    public function testSetStockScoringHigh()
    {
        $today = \Business\StockData::getToday();
        $stockindicator = new \Business\StockIndicator;   
        $stockindicator->setIndicatorRSI(50);
        $stockindicator->setMovingAverage(2,1,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(0.1);  
        $stockquote = new \Business\StockQuote;
        $stockquote->setQuote($today, 2, 1, 2);
        $score = $this->object->setStockScoring($stockindicator, $stockquote);
        $this->assertEquals(7,$score);
    }

    /**
     * @covers Business\StockAnalyseEngine::setRSIStockFactor     *
     */
    public function testGetRSIStockFactorLow()
    {       
        $stockindicator = new \Business\StockIndicator;    
        $stockindicator->setIndicatorRSI(30);
        $stockindicator->setMovingAverage(2,1,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(0.1);  
        $score  = $this->object->setRSIStockFactor($stockindicator);
        $this->assertEquals(0,$score);  
    }
    
    /**
     * @covers Business\StockAnalyseEngine::setRSIStockFactor   *
     */
    public function testGetRSIStockFactorHigh()
    {       
        $stockindicator = new \Business\StockIndicator;   
        $stockindicator->setIndicatorRSI(90);
        $stockindicator->setMovingAverage(2,1,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(0.1);  
        $highscore = $this->object->setRSIStockFactor($stockindicator);
        $this->assertEquals(4,$highscore);
    }
    
    /**
     * @covers Business\StockAnalyseEngine::setIndicatorEMAFactor
     *    
     */
    public function testsetIndicatorEMAFactor()
    {       
        $today = \Business\StockData::getToday();
        $stockindicator = new \Business\StockIndicator;   
        $stockindicator->setIndicatorRSI(90);
        $stockindicator->setMovingAverage(3,2,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(0.1);  
        $stockquote = new \Business\StockQuote;
        $stockquote->setQuote($today, 4, 1, 2);
        $highscore = $this->object->setIndicatorEMAFactor($stockindicator, $stockquote);
        $this->assertEquals(2,$highscore);
    }
    
    /**
     * @covers Business\StockAnalyseEngine::setIndicatorVolatiliyFactor
     *    
     */
    public function testsetIndicatorVolatiliyFactor()
    {       
        $stockindicator = new \Business\StockIndicator;   
        $stockindicator->setIndicatorRSI(90);
        $stockindicator->setMovingAverage(3,2,1);
        $stockindicator->setPerformance(2);     
        $stockindicator->setVolatility(2);  
        $highscore = $this->object->setIndicatorVolatiliyFactor($stockindicator);
        $this->assertEquals(0,$highscore);
    }
}
