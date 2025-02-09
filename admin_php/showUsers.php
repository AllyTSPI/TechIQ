<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

     // Handle quiz deletion
     if (isset($_POST['deleteUsers'])) {
        $usersID = $_POST['usersID'];
        
        $deleteQuery = "DELETE FROM users WHERE userID = :userID";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':userID', $usersID, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "User deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete user.";
        }
        header("Location: ../admin_files/adminPanel.php");
        exit();
    }

    // Fetch subjects from the database
    $query = "SELECT userID, fullname, username, depedAcct, email, lastLoginDate FROM users ORDER BY lastLoginDate DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>