<?php

    //Downloads
    if(isset($_GET['fileName']))
    {
        $fileName = $_GET['fileName'];
    
        $stmt = $pdo->prepare("SELECT fileName, attachment, downloads FROM learningMaterials WHERE fileName = :fileName LIMIT 1");
        $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
        $stmt->execute();
        $material = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($material) 
        {
            // Increment downloads count
            $newDownloads = (int) $material['downloads'] + 1;
            $updateQuery = "UPDATE learningMaterials SET downloads = :downloads WHERE fileName = :fileName";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':downloads', $newDownloads, PDO::PARAM_INT);
            $updateStmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
            $updateStmt->execute();

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($material['fileName']) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($material['attachment']));
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
    
            echo $material['attachment'];
            exit;
        } 
        else{
            echo "File not found!";
            exit;
        }
    } 
    
    // Display learning materials for the user
    $query = "SELECT * FROM learningMaterials ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // File Preview
    if(isset($_GET['viewFileID'])) 
    {
        $fileName = urldecode($_GET['viewFileID']);

        $query = "SELECT attachment, moduleName, views FROM learningMaterials WHERE fileName = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$fileName]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if($file) {
            $fileData = $file['attachment'];
            $moduleName = $file['moduleName'];
            $currentViews = (int) $file['views'];
            $newViews = $currentViews + 1;

            // Update views count
            $updateQuery = "UPDATE learningMaterials SET views = ? WHERE fileName = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$newViews, $fileName]);

            // Check if the update was successful
            if($updateStmt->rowCount() > 0) {
                error_log("Views updated successfully for $fileName. New count: $newViews");
            } 
            else{
                error_log("Views update failed or no change detected for $fileName");
            }

            // Get file mime type dynamically
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($fileData);

            // Set headers to display the file
            header("Content-Type: $mimeType");
            header("Content-Disposition: inline; filename=\"$moduleName\"");
            echo $fileData;
            exit;
        } 
        else{
            error_log("File not found: $fileName");
            echo "File not found!";
            exit;
        }
    }

?>