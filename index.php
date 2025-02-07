<?php
    session_start();
    require 'config/connection.php';

    $error_message = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Update the lastLoginDate to the current timestamp
                $updateStmt = $pdo->prepare("UPDATE users SET lastLoginDate = NOW() WHERE userID = :userID");
                $updateStmt->bindParam(':userID', $user['userID'], PDO::PARAM_INT);
                $updateStmt->execute();

                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];

                // Redirect to landing.php
                header("Location: landing.php");
                exit();
            } else {
                // If username or password is incorrect, show an error message
                $error_message = "Incorrect username or password. Please try again.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
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
                    <button id="getStartedBtn" class="btn btn-primary">Get Started</button>
                </div>  
    
                <!-- Sidebar Section -->
                <div class="col-lg-4 col-md-12 custom-form form-margin">
                    
                    <div class="card" id="formCard" style="display: none;">
                        <div class="card-header text-center" id="formHeader">Login</div> 
                            <div class="card-body" id="formBody">

                                <!-- Default Login Form -->
                                <form id="loginForm" action="index.php" method="POST">
                                    <!--Insert danger alert php-->
                                     <!-- Display error message if credentials are incorrect -->
                                    <?php if ($error_message): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Username input -->
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>

                                    <!-- Submit for login -->
                                    <button type="submit" class="btn btn-yellow btn-block">LOGIN</button>

                                    <!-- forgot password and create account -->
                                    <div class="form-group text-center mt-3">
                                        <a href="forgotpass.php" class="btn btn-link btn-sm custom-link">Forgot Password</a>
                                        <span class="mx-2">|</span>
                                        <a href="createaccount.php" class="btn btn-link btn-sm custom-link">Create Account</a>
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