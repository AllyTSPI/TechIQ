<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../config/connection.php';

    // Fetch subjects from the database
    $query = "SELECT id, name, lastLoginDate FROM admin ORDER BY lastLoginDate DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>