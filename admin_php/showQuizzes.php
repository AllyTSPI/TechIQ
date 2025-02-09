<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    // Fetch subjects from the database
    $query = "SELECT ID, quizCode, subjectName, quizLink FROM quizzess ORDER BY dateCreated DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>