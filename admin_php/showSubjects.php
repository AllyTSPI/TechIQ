<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    
    // Fetch subjects from the database
    $query = "SELECT ID, subjectCode, subjectName, dateAdded, addedBy FROM subjects ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>