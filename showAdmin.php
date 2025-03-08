<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require 'connection.php';

     // Handle quiz deletion
    if (isset($_POST['deleteAdmin'])) {
        $adminID = $_POST['adminID'];
        
        $deleteQuery = "DELETE FROM admin WHERE id = :id";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':id', $adminID, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Admin deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete admin.";
        }
        header("Location: adminPanel.php");
        exit();
    }


    // Fetch subjects from the database
    $query = "SELECT id, name, lastLoginDate FROM admin ORDER BY lastLoginDate DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>