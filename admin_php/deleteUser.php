<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../config/connection.php';

    if (!isset($_GET['userID']) || !is_numeric($_GET['userID'])) {
        die("Invalid request for deleting user. Debug: userID is " . (isset($_GET['userID']) ? var_export($_GET['userID'], true) : "NOT SET"));
    }

    $userID = $GET['userID'];

    try{
        $stmt = $pdo->prepare("DELETE FROM users WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        
        if ($stmt->execute()){
            header("Location: ../admin_files/adminPanel.php?message=User deleted successfully");
            exit();
        } 
        else{
            die("\t\t\t\t\t\t\t\t\tError deleting user.");
        }
    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
