<?php

namespace Test;

class HomepageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that the index route returns a rendered response 
     */
    public function testGetHomepage() 
    {       
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/');
        $this->assertContains('Stockscreener', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    /**
     * Test that the API returns 200 for GET Stocks
     * 
     *  
     */
   
    public function testAPIGetStocks() 
    {      
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/api/stocks');
        $this->assertEquals(200, $response->getStatusCode());        
    }
    
    /**
     * Test that the API returns 200 for POSTStocks
     * 
     *  
     */
    public function testAPIGPostStocks() 
    {       
        $appRunner = new \Support\AppRunner; 
        $response = $appRunner->runMockApp('POST', '/api/stocks');
        $this->assertEquals(200, $response->getStatusCode());        
    }
}