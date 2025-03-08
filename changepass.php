<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Password not match! Please try again.'); window.history.back();</script>";
        exit;
    }
    
    try {
        // Get the logged-in user ID (assuming userID is stored in session)
        if (!isset($_SESSION['userID'])) {
            echo "<script>alert('User not authenticated!'); window.location.href='index.php';</script>";
            exit;
        }

        $userID = $_SESSION['userID'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash password for security
        $updatedDate = date('Y-m-d H:i:s');
        
        // Prepare SQL statement
        $stmt = $pdo->prepare("UPDATE users SET password = :password, updatedDate = :updatedDate WHERE userID = :userID");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':updatedDate', $updatedDate);
        $stmt->bindParam(':userID', $userID);
        
        if ($stmt->execute()) {
            echo "<script>alert('Password changed successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error updating password. Please try again.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>




<!doctype html>
<html lang="en">
    <!--head-->
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/styles.css">

        <title>TechIQ</title>

        <style>
          .navbar-nav,
          .form-inline {
            display: none;
          }
      
          /* Keep the navbar-brand visible */
          .navbar-brand {
            display: block;
          }
        </style>    
    </head>
    
    <!--body-->
    <body class="index">
        <!---navbar-->
        <nav class="navbar navbar-expand-lg navbar-light custom-nav">
            <a class="navbar-brand" href="#">TechIQ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i> 
            </button>
        </nav>
        <!---end navbar-->
        
        <!--Content-->
        <div class="container mt-5">
            <div class="row">
                <!-- Main Content Section -->
                <div class="col-lg-8 col-md-12 mb-4">
                    <h2 class="mb-3">Empower Your Learning</h2>
                    <p>Unleash your potential.</p>
                </div>  
    
                <!-- Sidebar Section -->
                <div class="col-lg-4 col-md-12 custom-form form-margin create-account">
                    
                    <div class="card" id="formCard">
                        <div class="card-header text-center" id="formHeader">Change Password</div> 
                            <div class="card-body" id="formBody">

                                <!-- Default Login Form -->
                                <form id="loginForm" action="" method="POST">
                                    <!--Insert danger alert php-->
                                    
                                    <!-- new password input -->
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control" name="newPassword" required>
                                    </div>
                                    <!-- confirm new Password input -->
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirmPassword" required>
                                    </div>

                                    <!-- Submit for login -->
                                    <button type="submit" class="btn btn-yellow btn-block">SUBMIT</button>

                                    <!-- forgot password and create account -->
                                    <div class="form-group text-center mt-3">
                                        <a href="createaccount.php" class="btn btn-link btn-sm custom-link">Create Account</a>
                                        <span class="mx-2">|</span>
                                        <a href="index.php" class="btn btn-link btn-sm custom-link">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
      <!--Call JS-->
      <script src="js/scripts.js"></script>
    </body>
  </html>