<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require '../config/connection.php';

    if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
        die("Invalid request for deleting subjects. Debug: ID is " . (isset($_GET['ID']) ? var_export($_GET['ID'], true) : "NOT SET"));
    }
    

    $subjectID = $_GET['ID'];

    try {
        // Prepare the DELETE query
        $stmt = $pdo->prepare("DELETE FROM subjects WHERE ID = :ID");
        $stmt->bindParam(':ID', $subjectID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../admin_files/adminPanel.php?message=Subject deleted successfully");
            exit();
        } else {
            die("Error deleting subject.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
?>
