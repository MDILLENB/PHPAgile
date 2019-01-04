<?php


namespace Test;
use Business\StockController;
use Support\Dependencies;

/**
 * Description of StockControllerTest
 *
 * @author Marco
 */
class StockControllerTest extends \PHPUnit\Framework\TestCase {
    
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
        $dependencies = new Dependencies($container);
        $dependencies->registerLogger();
        $dependencies->registerDatabase();
        $this->object = new StockController($container);
        
    }
    /**
     * @covers Business\StockController::getScoringsbyTicker
     * 
     */
    public function testgetScoringsbyTicker()
    {       
        
        $scorings = $this->object->getScoringsbyTicker("FWB:BDT");
        $this->assertEquals("FWB:BDT",$scorings[0]->ticker);
       
    }
    
    /**
     * @covers Business\StockController::getBasics
     * 
     */
    public function testgetBasics()
    {       
        
        $stock = $this->object->getBasics("FWB:BDT");
        $this->assertEquals("FWB:BDT",$stock->ticker);
       
    }
}
