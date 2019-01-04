<?php

namespace Test;


/**
 * Description of StockDataInterfaceTest
 *
 * @author Marco
 */
class StockDataInterfaceTest {

  
    
    public function testAPIGetStocks() {
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/api/stocks');
        $this->assertEquals(200, $response->getStatusCode());
        $json = json_decode($response->getBody(), TRUE);
        foreach ($json as $item) {
            $this->assertEquals($item['region'], 'germany');
        }
    }

    /**
     * Test is beberlei collaborator of doctrine/cache
     */
    public function testAPIPostStocks() {
        $appRunner = new \Support\AppRunner;
        $response = $appRunner->runMockApp('GET', '/api/stocks');
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
