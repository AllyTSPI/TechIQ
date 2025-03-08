<?php

        $host = "localhost";
        $dbname = "techiq";
        $username = "root"; // Change if needed
        $password = ""; // Change if needed

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                PDO::ATTR_EMULATE_PREPARES => false, 
            ]);

            //echo"connected to db";

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
?>