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
use Resource\Database\Scoring;
use Slim\Container;

/**
 * ScoringResource manages Scoring Resources in Database
 *
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 */
class ScoringResource extends AbstractResource
{

    protected $container;

    /**
     * Constructor with injection of container
     * 
     * @param Container $container to inject
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get Scoringdata by ticker
     * 
     * @param String $ticker to get Scoringdata
     *
     * @return string
     */
    public function getScoringsbyTicker($ticker)
    {
        $entitymanager = $this->getEntityManager(
            $this->container->get('database')
        );
        $query = $entitymanager->createQuery(
            "SELECT u.ticker, u.date, "
            . "u.scoring, u.highMonth, u.close, u.lowMonth,"
            . "u.perfWeek, u.smaLongterm, "
            . "u.emaMonth, u.emaFiveMonth, u.rsiWeek, "
            . "u.volatilityWeek FROM Resource\Database\Scoring u "
            . "WHERE u.ticker ='" . $ticker . "' "
            . " ORDER BY u.date DESC"
        )
            ->setMaxResults(10);
        $scorings = $query->getResult();
        $stocks = array();
        foreach ($scorings as $item) {
            $stockdata = new \Business\StockData();
            $stockdata->ticker = $item['ticker'];
            $stockindicator = new \Business\StockIndicator();
            $stockindicator->date = $item['date'];
            $stockindicator->scoring = $item['scoring'];
            $stockindicator->smaLongterm = $item['smaLongterm'];
            $stockindicator->emaMonth = $item['emaMonth'];
            $stockindicator->emaFiveMonth = $item['emaFiveMonth'];
            $stockindicator->rsiWeek = $item['rsiWeek'];
            $stockindicator->performanceWeek = $item['perfWeek'];
            $stockindicator->volatilityw = $item['volatilityWeek'];
            $stockdata->setIndicator($stockindicator);
            $stockquote = new \Business\StockQuote();
            $stockquote->highMonth = $item['highMonth'];
            $stockquote->close = $item['close'];
            $stockquote->lowMonth = $item['lowMonth'];
            $stockquote->date = $item['date'];
            $stockdata->setQuote($stockquote);
            array_push($stocks, $stockdata);
        }
        $entitymanager->flush();
        $entitymanager->clear();
        return $stocks;
    }

    /**
     * Create Scoringdata
     * 
     * @param type $stocks to create
     * 
     * @return empty
     */
    public function create($stocks)
    {
        $entitymanager = $this->getEntityManager($this->container->get('database'));
        foreach ($stocks as $stockdata) {
            $scoring = new Scoring();
            $scoring->ticker = $stockdata->ticker;
            $stockindicator = $stockdata->getIndicator();
            $scoring->date = $stockindicator->date;
            $scoring->scoring = $stockindicator->scoring;
            $scoring->volatilityWeek = $stockindicator->volatilityWeek;
            $scoring->smaLongtermn = $stockindicator->smaLongterm;
            $scoring->emaMonth = $stockindicator->emaMonth;
            $scoring->emaFiveMonth = $stockindicator->emaFiveMonth;
            $scoring->rsiWeek = $stockindicator->rsiWeek;
            $scoring->perfWeek = $stockindicator->performanceWeek;
            $stockquote = $stockdata->getQuote();
            $scoring->highMonth = $stockquote->highMonth;
            $scoring->close = $stockquote->close;
            $scoring->lowMonth = $stockquote->lowMonth;
            $entitymanager->persist($scoring);
        }
        $entitymanager->flush();
        $entitymanager->clear();
    }

}
