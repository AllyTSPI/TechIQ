<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require 'connection.php';

    // Handle quiz deletion
    if (isset($_POST['deleteQuiz'])) {
        $quizID = $_POST['quizID'];
        
        $deleteQuery = "DELETE FROM quizzess WHERE ID = :quizID";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Quiz deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete quiz.";
        }
        header("Location: adminPanel.php");
        exit();
    }

    // Fetch quizzes from the database
    $query = "SELECT ID, quizCode, subjectName, quizLink FROM quizzess ORDER BY dateCreated DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>