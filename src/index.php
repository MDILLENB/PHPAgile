<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Index
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/

require __DIR__ . '/../vendor/autoload.php';

session_start();
$apprunner = new \Support\AppRunner();
$apprunner->runApp();