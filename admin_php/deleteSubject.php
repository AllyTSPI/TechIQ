<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';


    if (isset($_GET['code'])) {
        $subjectCode = $_GET['code'];
    
        $deleteQuery = "DELETE FROM subjects WHERE subjectCode = :subjectCode";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':subjectCode' => $subjectCode]);
    
        header("Location: adminPanel.php");
        exit();
    }

?>