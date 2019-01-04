<?php


namespace Test;

use Resource\Database\StockResource;
use Support\Dependencies;
/**
 * Description of ScoringResouceTest
 *
 * @author Marco
 */
class StockResourceTest  extends \PHPUnit\Framework\TestCase{
    
    protected $object;
    protected $ci;  
    
      /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {      
        $settings = require __DIR__ . '/../../../config/settings.php';
        $container = new \Slim\Container($settings);
        $container['stockconfig'] = function ($config) {
             $stockconfig =$config['settings']['stockconfig'];  
             return $stockconfig;
        };
        $dependencies = new Dependencies($container);
        $dependencies->registerLogger();
        $dependencies->registerDatabase();
        $this->object = new StockResource($container);
        
    }
    
    /**
     * @covers Resource\Database\StockResource::getBasics
     * 
     */
    public function testgetBasics()
    {       
        
        $stock= $this->object->getBasics("FWB:BDT");
        $this->assertEquals("FWB:BDT",$stock->ticker);
       
    }
    
}

