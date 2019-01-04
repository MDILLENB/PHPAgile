<?php

namespace Test;

use Resource\Database\ScoringResource;
use Support\Dependencies;
/**
 * Description of ScoringResouceTest
 *
 * @author Marco
 */
class ScoringResouceTest  extends \PHPUnit\Framework\TestCase{
    
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
        $this->object = new ScoringResource($container);
        
    }
    
    /**
     * @covers Resource\Database\ScoringResource::getScoringsbyTicker
     * 
     */
    public function testgetScoringsbyTicker()
    {       
        
        $scorings = $this->object->getScoringsbyTicker("FWB:BDT");
        $this->assertEquals("FWB:BDT",$scorings[0]->ticker);
       
    }
    
}
