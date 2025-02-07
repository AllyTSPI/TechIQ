<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../config/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subjectCode = $_POST['subjectCode'];
        $moduleName = $_POST['moduleName'];
    
        // Handle File Upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
            $fileName = $_FILES['attachment']['name'];
            $fileTmp = $_FILES['attachment']['tmp_name'];
            $fileType = $_FILES['attachment']['type'];
            $fileSize = $_FILES['attachment']['size'];
            $fileContent = file_get_contents($fileTmp);
    
            // Default values for views, downloads, favorites
            $views = 0;
            $downloads = 0;
            $favorites = 0;
    
            // Insert into Database
            $stmt = $pdo->prepare("INSERT INTO learningMaterials (subjectCode, moduleName, fileName, attachment, views, downloads, favorites, dateAdded) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bindParam(1, $subjectCode);
            $stmt->bindParam(2, $moduleName);
            $stmt->bindParam(3, $fileName);
            $stmt->bindParam(4, $fileContent, PDO::PARAM_LOB);
            $stmt->bindParam(5, $views, PDO::PARAM_INT);
            $stmt->bindParam(6, $downloads, PDO::PARAM_INT);
            $stmt->bindParam(7, $favorites, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo "<script>alert('Learning material uploaded successfully!'); window.location.href='../admin_files/adminPanel.php';</script>";
            } else {
                echo "<script>alert('Error uploading learning material.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Please select a valid file.'); window.history.back();</script>";
        }
    }

    // Display the materials
    $query = "SELECT ID, subjectCode, moduleName, fileName, dateAdded FROM learningMaterials ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
