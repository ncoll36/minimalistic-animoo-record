<?php
//----------------------------------------------- Connection to Database ---------------------------------------------//

    function connection() {
        //  Connection details in array (add real username details here)
        $config = array(
            'host'     => 'localhost',
            'username' => 'username',
            'password' => 'password',
            'db_name'  => 'name'
        );

        try {

            // Establish connection using above parameters

            $link = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'],
                $config['username'], $config['password']);

            // Debugging for errors
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Returns pdo object connection
            return $link;
        } catch (PDOException $e) {
            die("Database connection failed. Please try again later, or contact system admin to report this issue");
        }
    }

?>