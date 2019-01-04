<?php
/**
 * PHP Version 7
 * 
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/

namespace Resource\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Abstract Resource to define Datbase EntityManager and Setup
 *
 * @category Stockscreener
 * @package  Resource\Database
 * @author   Marco Dillenburg <mail@marcodillenburg.de>
 * @license  MIT License
 * @link     www.marcodillenburg.de
 **/
abstract class AbstractResource
{

    /**
     * EntityyManager to access Database
     * 
     * @var \Doctrine\ORM\EntityManager to manage Database access
     */
    protected $entityManager = null;

    /**
     * Get EntitiyManager to access Database
     * 
     * @param type $connectionOptions to create Database Connection
     * 
     * @return EntityManager
     */
    public function getEntityManager($connectionOptions) 
    {
        if ($this->entityManager === null) {
            $this->entityManager = $this->createEntityManager($connectionOptions);
        }

        return $this->entityManager;
    }

    /**
     * Create Entitiy Manager
     * 
     * @param type $connectionOptions to create Database Connection
     * 
     * @return EntityManager
     */
    public function createEntityManager($connectionOptions) 
    {
        $path = array('Resource/Database');
        $devMode = false;

        $config = Setup::createAnnotationMetadataConfiguration($path, $devMode);
        return EntityManager::create($connectionOptions, $config);
    }

}