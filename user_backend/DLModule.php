<?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Include your database connection file
        require 'config/connection.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        require 'config/connection.php';
        
        if (isset($_GET['fileName'])) {
            // Get the fileName from the URL query parameter
            $fileName = $_GET['fileName'];
        
            // Prepare a PDO statement to fetch the file data from the database
            $stmt = $pdo->prepare("SELECT fileName, attachment FROM learningMaterials WHERE fileName = :fileName LIMIT 1");
            $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
            $stmt->execute();
        
            // Fetch the file record from the database
            $material = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($material) {
                // Set the headers to force download
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($material['fileName']) . '"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . strlen($material['attachment']));
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
        
                // Output the file contents (as binary data)
                echo $material['attachment'];
                exit; // Ensure no further code is executed after sending the file
            } else {
                // If the file doesn't exist in the database
                echo "File not found!";
                exit; // Prevent any further code execution
            }
        } else {
            // If fileName is not set in the URL, show this message
            echo "";
        }
?>
