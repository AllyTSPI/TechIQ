<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../config/connection.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    try {
        // Prepare the DELETE query
        $stmt = $pdo->prepare("DELETE FROM users WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to admin panel after successful deletion
            header("Location: ../admin_files/adminPanel.php?message=User deleted successfully");
            exit();
        } else {
            echo "Error deleting user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
