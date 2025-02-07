<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    // Fetch subjects from the database
    $query = "SELECT userID, fullname, username, depedAcct, email, lastLoginDate FROM users ORDER BY lastLoginDate DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>