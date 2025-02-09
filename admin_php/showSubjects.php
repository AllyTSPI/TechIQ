<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';


    // Handle quiz deletion
    if (isset($_POST['deleteSubject'])) {
        $subjectID = $_POST['subjectID'];
        
        $deleteQuery = "DELETE FROM subjects WHERE ID = :ID";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':ID', $subjectID, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Subject deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete subject.";
        }
        header("Location: ../admin_files/adminPanel.php");
        exit();
    }

    
    // Fetch subjects from the database
    $query = "SELECT ID, subjectCode, subjectName, dateAdded, addedBy FROM subjects ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>