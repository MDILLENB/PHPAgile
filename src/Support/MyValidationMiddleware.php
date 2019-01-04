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

use Respect\Validation\Validator;

/**
 * Class MyValidationMiddleware to validate Data
 *
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class MyValidationMiddleware
{

    /**
     * Register the Validator as Middleware
     * 
     * @return Validation $middleware
     */
    function register()
    {
        //Create the validators
        $tickerValidator = Validator::regex('/[A-Z]{2,4}[:][A-Z]{2,10}/')
            ->noWhitespace()->length(1, 14);
        $validators = array('ticker' => $tickerValidator);
        $middleware = new \DavidePastore\Slim\Validation\Validation($validators);
        return $middleware;
    }

}
