<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../config/connection.php';

    if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
        die("Invalid request for deleting module. Debug: ID is " . (isset($_GET['ID']) ? var_export($_GET['ID'], true) : "NOT SET"));
    }

    $moduleID = $_GET['ID'];

    try{
        $stmt = $pdo->prepare("DELETE FROM learningMaterials WHERE ID = :ID");
        $stmt->bindParam(':ID', $moduleID, PDO::PARAM_INT);

        if ($stmt->execute()){
            header("Location: ../admin_files/adminPanel.php?message=Module deleted successfully");
            exit();
        } 
        else {
            die("\t\t\t\t\t\t\t\t\tError deleting material.");
        }
    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
