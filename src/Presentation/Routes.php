<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Presentation
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */

namespace Presentation;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Container;

/**
 * StockIndicator for Business Object StockData
 *
 * @category Stockscreener
 * @package  Presentation
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 * */
class Routes
{

    protected $container;

    /**
     * Standard Constuctor 
     * 
     * @param Slim\Container $container to inject container     *  
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register routes in app
     * 
     * @param Slim\App $app to register
     * 
     * @return Response $resp to route
     */
    function register($app)
    {
        $app->post(
            '/analyseform', 
            /**
            * Register analysform POST route for app
            * 
            * @param Request  $request to register
            * @param Response $response to register
            */
            function (
                Request $request, Response $response
            ) use ($app) {
                $stockcontroller = $app->getContainer()->get('StockController');
                if ($request->getAttribute('has_errors')) {
                    $errors = $request->getAttribute('errors');
                    $resp = $app->getContainer()->view->render(
                        $response, "stockanalyseform.twig", 
                        ["messages" => $errors]
                    );
                } else {
                    $scorings = $stockcontroller->getScoringsbyTicker(
                        $request->getParam('ticker')
                    );
                    $resp = $app->getContainer()->view->render(
                        $response, "stockanalyseresults.twig", 
                        ["scorings" => $scorings]
                    );
                }
                return $resp;
            }
        );
       
        $app->get(
            '/analyseform', 
            /**
             * Register analysform GET route for app
             * 
             * @param Request  $request to register
             * @param Response $response to register
             * 
             * @return Response $resp
             */
            function (Request $request, Response $response) use ($app) 
            {
                $request->getUri();
                $resp = $app->getContainer()->view->render(
                    $response, "stockanalyseform.twig"
                );
                return $resp;
            }
        );
       
        $app->get(
            '/', 
            /**
             * Register standard route for app
             * 
             * @param Request  $request to register
             * @param Response $response to register
             * 
             * @return Response $resp
             */        
            function (Request $request, Response $response) use ($app) 
            {
                $request->getUri();
                $messages = array('message' => "");
                $resp = $app->getContainer()->view->render(
                    $response, 'index.twig', ["messages" => $messages]
                );
                return $resp;
            }
        );
    }
    /**
     * Register the API routes
     * 
     * @param type $app with application to register
     * 
     * @return empty
     */
    function registerAPI($app)
    {
        /**
         * Register api GET route for app
         * 
         * @param Request  $request to register
         * @param Response $response to register
         * 
         * @return Response $resp
         */
        $app->get(
            '/api/stocks', 
            function (Request $request, Response $response) use ($app) 
            {
                $request->getUri();
                $stockcontroller = $app->getContainer()->get('StockController');
                $resp = $response->withJson($stockcontroller->getStocks(), 200);
                return $resp;
            }
        );
        
        $app->post(
            '/api/stocks', 
            /**
             * Register api POST route for app
             * 
             * @param Request  $request to register
             * @param Response $response to register
             * 
             * @return Response $resp
             */
            function (Request $request, Response $response) use ($app) 
            {
                $request->getUri();
                $stockcontroller = $app->getContainer()->get('StockController');
                $message = $stockcontroller->postStocks();
                $messages = array();
                array_push($messages, $message);
                $resp = $response->withJson($messages, 200);
                return $resp;
            }
        );
    }
   
    /**
     * Check if GET Request and redirect
     * 
     * @param Request $request with Request to URL
     * 
     * @return type
     */
    function checkGET(Request $request) 
    {        
        if ($request->getMethod() === 'GET') {
            $request->getUri();
            /* @var $uri type */
            return $response->withRedirect((string) $uri, 301);
        } 
        return $next($request->withUri($uri), $response);        
    }
}
