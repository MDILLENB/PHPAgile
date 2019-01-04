<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/

namespace Support;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Slim\App;
use Slim\Container;

/**
 * Class to run a request against app, used to simulate Inrerface and execute Tests 
 *
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class AppRunner
{

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri    the request URI
     * @param array  $requestData   the request data
     * 
     * @return \Slim\Http\Response $resp
     */
    public function runMockApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $app = $this->initializeApp();
        // Set up a response object
        $response = new Response();
        // Process the application
        $resp = $app->process($request, $response);

        // Return the response
        return $resp;
    }

    /**
     * Run Application
     * 
     * @return emptpy
     */
    function runApp()
    {

        $app = $this->initializeApp();
        $app->run();
    }

    /**
     * Registration of config in container
     * 
     * @param Container   $container to register 
     * @param Application $app       to register
     * 
     * @return empty
     */
    public function registration($container, $app)
    {
        /**
         * Register Container
         * 
         * @param Slim\Container $container to register
         * 
         * @return View view
         */    
        $container['view'] = function (Container $container) 
        {
            $view = new \Slim\Views\Twig(
                __DIR__ . '/../../src/Presentation/', [
                'cache' => false
                ]
            );
            $basePath = rtrim(
                str_ireplace(
                    'index.php', '', 
                    $container->get('request')
                        ->getUri()
                        ->getBasePath()
                ),
                '/'
            );
            $view->addExtension(
                new \Slim\Views\TwigExtension(
                    $container->get('router'), $basePath
                )
            );
            $view->addExtension(
                new \Twig\Extensions\I18nExtension()
            );
            $view->addExtension(
                new \Twig\Extensions\IntlExtension()
            );
            return $view;
        };

        // Register middleware
        $localisationmw = new MyLocalisationMiddleware();
        $app->add($localisationmw->register());
        $validationmw = new MyValidationMiddleware();
        $app->add($validationmw->register());

        // Register dependencies
        $dependencies = new Dependencies($container);
        $dependencies->registerStockController();
        $dependencies->registerStockData();
        $dependencies->registerConfig();
        $dependencies->registerDatabase();
        $dependencies->registerLogger();

        // Register routes
        $routes = new \Presentation\Routes($container);
        $routes->register($app);
        $routes->registerAPI($app);
    }

    /**
     * Initalize app with config and registration
     * 
     * @return App
     */
    function initializeApp()
    {
        // Use the application settings
        $config = include __DIR__ . '/../../config/settings.php';

        // Instantiate the application       
        $container = new Container($config);
        $app = new App($container);
        $this->registration($container, $app);
        return $app;
    }

}
