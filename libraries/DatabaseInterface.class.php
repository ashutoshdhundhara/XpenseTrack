<?php
/**
 * Main interface for all database interactions.
 */

if (! defined('XpenseTrack')) {
    exit;
}

/**
 * Include all DB constants.
 */
require_once 'libraries/dbConstants.inc.php';

/**
 * Class that manages all db interactions.
 */
class XT_DatabaseInterface
{
    /**
     * Constructor creates a new connection.
     */
    public function __construct()
    {
        $GLOBALS['db_link'] = $this->connect(dbHost, dbUser, dbPass, dbName);
    }

    /**
     * Connects to database.
     *
     * @param string $dbHost Hostname
     * @param string $dbUser Username
     * @param string $dbPass Password
     * @param string $dbName Database name
     *
     * @return resource $link PDO object
     */
    public function connect($dbHost, $dbUser, $dbPass, $dbName)
    {
        // Database engine (vendor specific).
        $engine = 'mysql';
        $connection_string = $engine
            . ':host=' . $dbHost
            . ';dbname=' . $dbName;
        try {
            $link = new PDO($connection_string, $dbUser, $dbPass);
        } catch (PDOException $excp) {
            die($excp->getMessage());
        }

        return $link;
    }

    /**
     * Runs a query and returns result.
     *
     * @param string $query Query to be run
     * @param array $param Array containing parameter-value pairs
     * @return resource $result PDO statement
     */
    public function executeQuery($query, $params = array())
    {
        $link = $GLOBALS['db_link'];
        if (empty($link)) {
            return false;
        }
        // Prepare statement.
        $stmt = $link->prepare($query);

        // Execute statement.
        $stmt->execute($params);
        // Fetch result.
        $result = $stmt;

        return $result;
    }
}

?>