<?php

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';

class StockAnalyseTest extends \PHPUnit\Framework\TestCase
{
   
    /**
     * Test that the analysform is displayed
     */
    public function testGetStockAnalyseForm()
    {        
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/analyseform');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test that the form sends a valid ticker to analyze
     * */
    public function testValidPostStockAnalyseForm()
    {
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('POST', '/analyseform',['ticker=XETR:MAN']);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test that the form sends a invalid ticker to analyze
     * */
    public function testInvalidPostStockAnalyseForm()
    {
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('POST', '/analyseform',['ticker=XM']);
        $this->assertEquals(200, $response->getStatusCode());
    }
     
     
    
}