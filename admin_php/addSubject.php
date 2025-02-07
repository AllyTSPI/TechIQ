<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    // Handle form submission to add a new subject
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subjectCode = trim($_POST['subjectCode']);
        $subjectName = trim($_POST['subjectName']);
        $addedBy = "Admin"; // You can change this to dynamically fetch the admin's name
        $dateAdded = date("Y-m-d H:i:s");

        if (!empty($subjectCode) && !empty($subjectName)) {
            $insertQuery = "INSERT INTO subjects (subjectCode, subjectName, dateAdded, addedBy) VALUES (:subjectCode, :subjectName, :dateAdded, :addedBy)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute([
                ':subjectCode' => $subjectCode,
                ':subjectName' => $subjectName,
                ':dateAdded' => $dateAdded,
                ':addedBy' => $addedBy
            ]);
            
            // Redirect to refresh the page and prevent resubmission
            header("Location: adminPanel.php");
            exit();
        }
    }

    // Fetch subjects from the database
    $query = "SELECT subjectCode, subjectName, dateAdded, addedBy FROM subjects ORDER BY dateAdded DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>