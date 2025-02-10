<?php

    if (isset($_GET['fileName'])) {
        session_start(); // Ensure session is started
        if (!isset($_SESSION['userID'])) {
            echo "User not logged in!";
            exit();
        }

        $fileName = $_GET['fileName'];
        $userID = $_SESSION['userID']; // Get the logged-in user's ID

        $stmt = $pdo->prepare("SELECT fileName, attachment, downloads, subjectCode FROM learningMaterials WHERE fileName = :fileName LIMIT 1");
        $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
        $stmt->execute();
        $material = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($material) {
            $subjectCode = $material['subjectCode'];
            $newDownloads = (int) $material['downloads'] + 1;

            // Update global downloads count
            $updateQuery = "UPDATE learningMaterials SET downloads = :downloads WHERE fileName = :fileName";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':downloads', $newDownloads, PDO::PARAM_INT);
            $updateStmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
            $updateStmt->execute();

            // Update user-specific progress
            $updateUserProgress = "INSERT INTO userProgress (userID, subjectCode, downloads) 
                                VALUES (:userID, :subjectCode, 1) 
                                ON DUPLICATE KEY UPDATE downloads = downloads + 1";
            $progressStmt = $pdo->prepare($updateUserProgress);
            $progressStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $progressStmt->bindParam(':subjectCode', $subjectCode, PDO::PARAM_STR);
            $progressStmt->execute();

            // Proceed with file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($material['fileName']) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($material['attachment']));
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            echo $material['attachment'];
            exit();
        } else {
            echo "File not found!";
            exit();
        }
    }
    
    // Display learning materials for the user
    $query = "SELECT * FROM learningMaterials ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // File Preview
    if (isset($_GET['viewFileID'])) {
        session_start();
        if (!isset($_SESSION['userID'])) {
            echo "User not logged in!";
            exit();
        }
    
        $fileName = urldecode($_GET['viewFileID']);
        $userID = $_SESSION['userID'];
    
        $query = "SELECT attachment, moduleName, views, subjectCode FROM learningMaterials WHERE fileName = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$fileName]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($file) {
            $fileData = $file['attachment'];
            $moduleName = $file['moduleName'];
            $subjectCode = $file['subjectCode'];
            $newViews = (int) $file['views'] + 1;
    
            // Update total views count
            $updateQuery = "UPDATE learningMaterials SET views = ? WHERE fileName = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$newViews, $fileName]);
    
            // Update user-specific views count
            $updateUserProgress = "INSERT INTO userProgress (userID, subjectCode, views) 
                                   VALUES (:userID, :subjectCode, 1) 
                                   ON DUPLICATE KEY UPDATE views = views + 1";
            $progressStmt = $pdo->prepare($updateUserProgress);
            $progressStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $progressStmt->bindParam(':subjectCode', $subjectCode, PDO::PARAM_STR);
            $progressStmt->execute();
    
            // Display the file inline
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($fileData);
    
            header("Content-Type: $mimeType");
            header("Content-Disposition: inline; filename=\"$moduleName\"");
            echo $fileData;
            exit();
        } else {
            echo "File not found!";
            exit();
        }
    }

?>