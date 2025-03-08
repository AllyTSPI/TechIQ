<?php
    session_start();

    require 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adminName = $_POST['adminName'];
        $password = $_POST['password'];
        
        try{
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE name = :adminName");
            $stmt->bindParam(':adminName', $adminName, PDO::PARAM_STR);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if($admin && $admin['password'] === $password){
                 // Correct credentials, update last login date
                $stmt = $pdo->prepare("UPDATE admin SET lastlogindate = NOW() WHERE id = :id");
                $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                $stmt->execute();

                // Store the user's ID in the session
                $_SESSION['admin'] = $user['id'];

                // Redirect to admin panel
                header('Location: adminpanel.php');
                exit();
            }
            else {
                // Incorrect credentials, show error message
                $error_message = "Incorrect name or password.";
            }
        }
        catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../css/admin-styles.css">
        <title>TechIQ - ADMIN</title>
    </head>
    <body class="admin gradient-custom">
        <section class="vh-100 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="card text-white">
                            <div class="card-body p-5 text-center">
                                <h2 class="fw-bold mb-4">Admin Login</h2>
                                <form action="adminLogin.php" method="POST">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" id="adminName" name="adminName" class="form-control" placeholder="Admin Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <?php if (isset($error_message)): ?>
                                        <div class="alert alert-danger mt-3"><?php echo $error_message; ?></div>
                                    <?php endif; ?>
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--Call JS-->
        <script src="./js/scripts.js"></script>
    </body>
</html>
