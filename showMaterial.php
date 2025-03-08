<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require 'connection.php';

    // Handle quiz deletion
    if (isset($_POST['deleteMaterial'])) {
        $materialID = $_POST['materialID'];
        
        $deleteQuery = "DELETE FROM learningMaterials WHERE ID = :materialID";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':materialID', $materialID, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Material deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete material.";
        }
        header("Location: adminPanel.php");
        exit();
    }


    // Display the materials
    $query = "SELECT ID, subjectCode, moduleName, fileName, dateAdded FROM learningMaterials ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>