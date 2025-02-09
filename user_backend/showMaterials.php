<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config/connection.php';

// Display learning materials for the user
$query = "SELECT ID, subjectCode, moduleName, fileName, dateAdded FROM learningMaterials ORDER BY dateAdded DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If a file preview is requested
if (isset($_GET['viewFileID'])) {
    $fileName = urldecode($_GET['viewFileID']);

    // Fetch file from the database
    $query = "SELECT attachment, moduleName FROM learningMaterials WHERE fileName = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$fileName]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        $fileData = $file['attachment'];
        $moduleName = $file['moduleName'];

        // Get file mime type dynamically
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($fileData);

        // Set headers to display the file
        header("Content-Type: $mimeType");
        header("Content-Disposition: inline; filename=\"$moduleName\"");
        echo $fileData;
        exit; // Stop script execution after file output
    } else {
        echo "File not found!";
        exit;
    }
}
?>
