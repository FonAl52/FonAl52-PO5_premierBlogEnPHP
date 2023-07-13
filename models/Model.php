<?php

abstract class Model
{

    /**
    * The database connection.
    *
    * @var PDO
    */
    protected static $bdd;

    /**
    * Establish a database connection.
    *
    * @return void
    */ 
    private static function setBdd()
    {

        // Retrieve database credentials from environment variables.
        $db_host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];

        // Create a new PDO instance for database connection.
        self::$bdd = new PDO("mysql:host=$db_host;port=8889;dbname=$db_name;charset=utf8", $db_username, $db_password);

        // Set PDO attributes to handle errors.
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    }//end setBdd()


    /**
    * Get the database connection.
    *
    * @return self::$bdd
    */
    protected function getBdd()
    {

        // Check if a database connection exists.
        if (self::$bdd == null) {

            // If not, establish a new connection.
            self::setBdd();
        }

        // Return the existing database connection.
        return self::$bdd;

    }//end getBdd()


}
