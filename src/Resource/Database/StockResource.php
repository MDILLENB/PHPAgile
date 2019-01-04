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

use Resource\Database\AbstractResource;
use Resource\Database\Stock;
use Slim\Container;

/**
 * Class StockResource to acess Stock Datas
 *
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 */
class StockResource extends AbstractResource
{

    protected $container;
    /**
     * Standard Constructor
     * 
     * @param Container $container to inject container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get Stockdata for stock ticer
     * 
     * @param String $ticker to set ticker
     *
     * @return Array
     */
    public function getBasics($ticker)
    {
        $entityManager = $this->getEntityManager($this->container->get('database'));
        $querybuilder = $entityManager->createQueryBuilder()
            ->select('s')
            ->from('Resource\Database\Stock', 's')
            ->where('s.ticker = :ticker')
            ->setParameter('ticker', $ticker)
            ->setMaxResults(1);
        $query = $querybuilder->getQuery();
        $stock = $query->getOneOrNullResult();
        $entityManager->flush();
        $entityManager->clear();
        return $stock;
    }

    /**
     * Get StockData by ticker
     * 
     * @param String $ticker to set ticker
     * 
     * @return Resource\Database\Stock
     */
    public function getbyTicker($ticker)
    {
        $entityManager = $this->getEntityManager($this->container->get('database'));
        $querybuilder = $entityManager->createQueryBuilder()
            ->select('u.name,u.ticker, u.region')
            ->from('Resource\Database\Stock', 'u')
            ->where('u.ticker = ?1')
            ->setParameter(1, $ticker)
            ->setMaxResults(1);
        $query = $querybuilder->getQuery();
        $stock = $query->getOneOrNullResult();
        $entityManager->flush();
        $entityManager->clear();
        return $stock;
    }

    /**
     * Get all Stocks by region
     * 
     * @param String $region for country selection
     * 
     * @return Array
     */
    public function getStocks($region)
    {
        $entityManager = $this->getEntityManager($this->container->get('database'));
        $querybuilder = $entityManager->createQueryBuilder()
            ->select('u')
            ->from('Resource\Database\Stock', 'u')
            ->where('u.region = ?1')
            ->setParameter(1, $region)
            ->groupBy('u.ticker')
            ->setMaxResults(10);
        $query = $querybuilder->getQuery();
        $stocks = $query->getResult();
        $entityManager->flush();
        $entityManager->clear();
        return $stocks;
    }

    /**
     * Create Stockdata in database
     * 
     * @param Array $stocks to create     
     * 
     * @return empty 
     **/
    public function create($stocks)
    {
        $entityManager = $this->getEntityManager($this->container->get('database'));
        foreach ($stocks as $stockdata) {
            if ($this->getbyTicker($stockdata->ticker) === null) {
                $stock = new Stock();
                $stock->name = $stockdata->name;
                $stock->ticker = $stockdata->ticker;
                $stock->industryGroup = $stockdata->industrygroup;
                $stock->region = $stockdata->region;
                $entityManager->persist($stock);
            }
        }
        $entityManager->flush();
        $entityManager->clear();
    }

    /**
     * Measure storing of new Stocks in database
     * 
     * @param Array $stocks to store
     * 
     * @return string
     */
    function persistStocks($stocks)
    {
        $start = microtime(true);
        $this->create($stocks);
        $scoringResource = new ScoringResource($this->container);
        $scoringResource->create($stocks);
        $end = microtime(true);
        $message = ' Persist ' . count($stocks) . ' in ' . ($end - $start) 
        . ' seconds';
        return $message;
    }

}
