<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 */

namespace Resource\Database;

use Doctrine\ORM\Mapping;

/**
 * Entity to store Quotes and Indicators
 * 
 * @Entity
 * @Table(name="stock")
 * @category            Stockscreener
 * @package             Resource\Database
 * @author              Marco Dillenburg <mail@marcodillenburg.de>
 * @license             MIT License
 * @link                www.marcodillenburg.de
 */
class Stock
{

    /**
     * Identifier to get Stock
     * 
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $identifier;

    /**
     * Name of Stock
     * 
     * @var string
     * @Column(type="string", length=64)
     */
    public $name;

    /**
     * Ticker of Stock
     * 
     * @var string
     * @Column(type="string", length=256)
     */
    public $ticker;

    /**
     * Industry Group of stock
     * 
     * @var string
     * @Column(type="string", length=255, name="industry_group")
     */
    public $industryGroup;

    /**
     * Stocks region
     * 
     * @var string
     * @Column(type="string", length=50)
     */
    public $region;
    
    /**
     *  Set Stock 
     * 
     * @param type $name          coporate name of stock
     * @param type $industrygroup stock industrygroup, i.e. traveling
     * @param type $region        stock region, i.e. germany
     * @param type $ticker        stock ticker, i.e. XETR:MAN
     * 
     * @return empty
     */
    protected function setStock($name, $industrygroup, $region, $ticker)
    {
        $this->name = $name;
        $this->industryGroup = $industrygroup;
        $this->region = $region;
        $this->ticker = $ticker;
    }
    
    /**
     * Get Identifier
     * 
     * @return type $identifier
     */
    protected function getIdentifier() 
    {
        return $this->identifier;
    }
    
}
