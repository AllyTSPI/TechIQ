<?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        require './config/connection.php';

         //display the materials for user
         $query = "SELECT ID, subjectCode, moduleName, fileName, dateAdded FROM learningMaterials ORDER BY dateAdded DESC";
         $stmt = $pdo->prepare($query);
         $stmt->execute();
         $learningMaterials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>