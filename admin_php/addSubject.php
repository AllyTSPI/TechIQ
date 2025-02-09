<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subjectCode = trim($_POST['subjectCode']);
        $subjectName = trim($_POST['subjectName']);
        $addedBy = "Admin";


        try{
            $stmt = $pdo->prepare("INSERT INTO subjects (subjectCode, subjectName, dateAdded, addedBy) 
                                   VALUES (:subjectCode, :subjectName, NOW(), :addedBy)");

            $stmt->bindParam(':subjectCode', $subjectCode);
            $stmt->bindParam(':subjectName', $subjectName);
            $stmt->bindParam(':addedBy', $addedBy);
            if ($stmt->execute()) {
                // Redirect to a confirmation page or the same page with a success message
                header("Location: ../admin_files/adminPanel.php?status=success");
                exit();
            } else {
                // Handle the error if the query fails
                die("Error: Unable to add the subject.");
            }
        }
        catch (PDOException $e) {
            // Handle PDO exceptions
            echo "Error: " . $e->getMessage();
        }  
    }

?>