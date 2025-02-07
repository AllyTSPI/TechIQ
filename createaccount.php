<?php
    require 'config/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $fullname = trim($_POST['fullname']);
            $username = trim($_POST['username']);
            $depedAcct = trim($_POST['depedAcct']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Validate required fields
            if (empty($fullname) || empty($username) || empty($depedAcct) || empty($email) || empty($password)) {
                echo "<script>alert('All fields are required!'); window.history.back();</script>";
                exit();
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement using PDO
            $stmt = $pdo->prepare("INSERT INTO users (fullname, username, depedAcct, email, password, createdDate, updatedDate, lastLoginDate) 
                                VALUES (:fullname, :username, :depedAcct, :email, :password, NOW(), '', '')");

            // Bind values
            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':depedAcct', $depedAcct, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

            // Execute the statement
            if ($stmt->execute()) {
                // Store user info in session
                $_SESSION['userID'] = $pdo->lastInsertId(); // Get the last inserted user ID
                $_SESSION['username'] = $username;

                echo "<script>
                        alert('Account successfully created!');
                        window.location.href='index.php';
                    </script>";
            } else {
                echo "<script>alert('Error: Could not create account.');</script>";
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
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
                        <div class="card-header text-center" id="formHeader">Create Account</div> 
                            <div class="card-body" id="formBody">

                                <!-- Default Login Form -->
                                <form id="loginForm" action="" method="POST">
                                    <!--Insert danger alert php-->
                                    
                                    <!-- Fullname input -->
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" name="fullname" required>
                                    </div>
                                    <!-- Username input -->
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                    <!-- Deped Account input -->
                                    <div class="form-group">
                                        <label for="depedAcct">LRN</label>
                                        <input type="text" class="form-control" name="depedAcct" required>
                                    </div>
                                    <!-- Email input -->
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>

                                    <!-- Submit for login -->
                                    <button type="submit" class="btn btn-yellow btn-block">CREATE ACCOUNT</button>

                                    <!-- forgot password and create account -->
                                    <div class="form-group text-center mt-3">
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