<?php
    session_start();

    // Include the database connection using PDO (make sure this file exists and is correct)
    require 'config/connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = trim($_POST['fullname']);
        $depedAcct = trim($_POST['depedAcct']);
        $username = trim($_POST['username']);
    
        try {
            $sql = "SELECT * FROM users WHERE fullname = :fullname AND depedAcct = :depedAcct AND username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['fullname' => $fullname, 'depedAcct' => $depedAcct, 'username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                $_SESSION['userID'] = $user['userID']; // Store user ID in session
                header("Location: changepass.php"); // Redirect to change password page
                exit();
            } else {
                echo "<script>alert('Incorrect input of credentials. Please try again.'); window.location.href='forgotpass.php';</script>";
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
                        <div class="card-header text-center" id="formHeader">Forgot Password</div> 
                            <div class="card-body" id="formBody">

                                <!-- Default Login Form -->
                                <form id="loginForm" action="" method="POST">
                                    <!--Insert danger alert php-->
                                    
                                    <!-- fullname input -->
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" name="fullname" required>
                                    </div>
                                    <!-- deped account input -->
                                    <div class="form-group">
                                        <label for="depedAcct">LRN</label>
                                        <input type="text" class="form-control" name="depedAcct" required>
                                    </div>
                                    <!-- Deped Account input -->
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" required>
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