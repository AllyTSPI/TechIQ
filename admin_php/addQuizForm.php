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
    
        if (isset($_FILES['quizIcon']) && $_FILES['quizIcon']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['quizIcon']['tmp_name'];
            $fileType = $_FILES['quizIcon']['type'];
    
            // Read the file content
            $quizIcon = file_get_contents($fileTmpPath);
    
            try {
                // Prepare the SQL query to insert the data
                $stmt = $pdo->prepare("INSERT INTO quizzess (quizCode, subjectName, quizLink, quizIcon, dateCreated) 
                                       VALUES (:quizCode, :subjectName, :quizLink, :quizIcon, NOW())");
    
                $stmt->bindParam(':quizCode', $quizCode);
                $stmt->bindParam(':subjectName', $subjectName);
                $stmt->bindParam(':quizLink', $quizLink);
                $stmt->bindParam(':quizIcon', $quizIcon, PDO::PARAM_LOB);
    
                // Execute the query
                if ($stmt->execute()) {
                    header("Location: ../admin_files/adminPanel.php?status=success");
                    exit();
                } else {
                    die("Error: Unable to add the quiz.");
                }
            } 
            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } 
        else {
            die("Error: File upload failed.");
        }
    }

?>