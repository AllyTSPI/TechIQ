<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve file details
    $stmt = $pdo->prepare("SELECT fileName, attachment FROM learningMaterials WHERE ID = ?");
    $stmt->execute([$id]);
    $material = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($material) {
        $fileName = $material['fileName']; // Original file name
        $fileContent = $material['attachment']; // BLOB data

        // Set headers for file download
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Length: " . strlen($fileContent));

        // Output file content
        echo $fileContent;
        exit;
    } else {
        echo "File not found.";
    }
}
?>
