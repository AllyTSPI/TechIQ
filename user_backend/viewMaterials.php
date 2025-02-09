<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require 'config/connection.php';

    
    if (isset($_GET['viewFileID'])) {
        $fileName = urldecode($_GET['viewFileID']);
    
        // Fetch file from the database
        $query = "SELECT attachment, moduleName FROM learningMaterials WHERE fileName = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($fileData, $moduleName);
            $stmt->fetch();
    
            // Get file mime type based on extension (assuming it's a PDF, image, etc.)
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($fileData);
    
            // Set headers
            header("Content-Type: $mimeType");
            header("Content-Disposition: inline; filename=\"$moduleName\"");
            echo $fileData;
        } else {
            echo "File not found!";
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request!";
    }




?>