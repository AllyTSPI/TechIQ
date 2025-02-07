<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../config/connection.php';

    
    if (isset($_GET['viewFileID'])) {
        $fileName = urldecode($_GET['viewFileID']);
    
        // Query the database to get the file path for the file
        $query = "SELECT attachment FROM learningMaterials WHERE fileName = :fileName LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
        $stmt->execute();
    
        // Fetch the file path from the database
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($file) {
            $filePath = $file['attachment']; // Path to the file (make sure this is the actual path or URL)
    
            // Check if the file exists
            if (file_exists($filePath)) {
                echo "<iframe src='$filePath' width='100%' height='600px'></iframe>"; // Embed PDF in iframe
            } else {
                echo "File not found or cannot be accessed.";
            }
        } else {
            echo "File not found in database.";
        }
    } else {
        echo "No file selected for preview.";
    }




?>