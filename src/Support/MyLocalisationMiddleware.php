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

use Boronczyk\LocalizationMiddleware;

/**
 * MyLocalisationMiddleware to handle localisation of time, language
 *
 * @category Stockscreener
 * @package  Support
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
class MyLocalisationMiddleware
{

    /**
     * Register Middleware in application
     *  
     * @return Middleware $middleware to register Localisation
     */
    public function register()
    {
        $availableLocales = ['de_DE', 'en_UK'];
        $defaultLocale = "de_DE";

        $middleware = new LocalizationMiddleware($availableLocales, $defaultLocale);
        $middleware->setSearchOrder(
            [
            LocalizationMiddleware::FROM_URI_PARAM,
            LocalizationMiddleware::FROM_COOKIE,
            LocalizationMiddleware::FROM_HEADER
            ]
        );

        $middleware->setLocaleCallback(
            /**
             * Set Settings for locale
             * 
             * @param string $locale for settings
             * 
             * @return empty
             */    
            function (string $locale) 
            {
                putenv('LC_ALL=' . $locale);
                setlocale(LC_ALL, $locale);
                // Specify the location of the translation tables
                bindtextdomain('stockscreener', '../config');
                bind_textdomain_codeset('stockscreener', 'UTF-8');
                textdomain('stockscreener');
            }
        );

        $middleware->setUriParamName('lang');
        return $middleware;
    }
}
