<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data
        $quizCode = $_POST['quizCode'];
        $subjectName = $_POST['subjectName'];
        $quizLink = $_POST['quizLink'];
    
        try {
            // Prepare the SQL query to insert the data
            $stmt = $pdo->prepare("INSERT INTO quizzess (quizCode, subjectName, quizLink, dateCreated) 
                                   VALUES (:quizCode, :subjectName, :quizLink, NOW())");
    
            // Bind the values to the prepared statement
            $stmt->bindParam(':quizCode', $quizCode);
            $stmt->bindParam(':subjectName', $subjectName);
            $stmt->bindParam(':quizLink', $quizLink);
    
            // Execute the query
            if ($stmt->execute()) {
                // Redirect to a confirmation page or the same page with a success message
                header("Location: ../admin_files/adminPanel.php?status=success");
                exit();
            } else {
                // Handle the error if the query fails
                echo "Error: Unable to add the quiz.";
            }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "Error: " . $e->getMessage();
        }
    }




    // Fetch subjects from the database
    $query = "SELECT ID, quizCode, subjectName, quizLink FROM quizzess ORDER BY dateCreated DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>