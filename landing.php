<?php
    session_start();
    require 'config/connection.php';

    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

    $username = $_SESSION['username'];

    // Handle profile update
    if (isset($_POST['saveProfile'])) 
    {
        $newFullname = $_POST['fullname'];
        $newDepedAcct = $_POST['depedAcct'];
        $newEmail = $_POST['email'];
        $profileImage = null;
        $coverImage = null;

        // Check if profile picture was uploaded
        if (isset($_FILES['userPhoto']) && $_FILES['userPhoto']['error'] === UPLOAD_ERR_OK) {
            $profileImage = file_get_contents($_FILES['userPhoto']['tmp_name']);
        }

        // Check if cover photo was uploaded
        if (isset($_FILES['userCover']) && $_FILES['userCover']['error'] === UPLOAD_ERR_OK) {
            $coverImage = file_get_contents($_FILES['userCover']['tmp_name']);
        }

        // Construct SQL query based on available inputs
        $updateQuery = "UPDATE users SET fullname = :fullname, depedAcct = :depedAcct, email = :email";

        if ($profileImage !== null) {
            $updateQuery .= ", userPhoto = :userPhoto";
        }
        if ($coverImage !== null) {
            $updateQuery .= ", userCover = :userCover";
        }

        $updateQuery .= " WHERE username = :username";
        $updateStmt = $pdo->prepare($updateQuery);

        // Bind parameters
        $updateStmt->bindParam(':fullname', $newFullname, PDO::PARAM_STR);
        $updateStmt->bindParam(':depedAcct', $newDepedAcct, PDO::PARAM_STR);
        $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $username, PDO::PARAM_STR);

        if ($profileImage !== null) {
            $updateStmt->bindParam(':userPhoto', $profileImage, PDO::PARAM_LOB);
        }
        if ($coverImage !== null) {
            $updateStmt->bindParam(':userCover', $coverImage, PDO::PARAM_LOB);
        }

        if ($updateStmt->execute()) {
            echo "";
        } else {
            echo "Error updating profile.";
        }
    }

    // Fetch user details including cover photo
    $query = "SELECT fullname, username, depedAcct, email, userPhoto, userCover FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      echo "User not found.";
      exit();
    }

    // Assign user details
    $fullname = $user['fullname'];
    $username = $user['username'];
    $depedAcct = $user['depedAcct'];
    $email = $user['email'];

    $profilePic = !empty($user['userPhoto']) ? 'data:image/jpeg;base64,' . base64_encode($user['userPhoto']) : 'images/profiles/default.png';
    $coverPhoto = !empty($user['userCover']) ? 'data:image/jpeg;base64,' . base64_encode($user['userCover']) : 'images/covers/cover.jpg';

    $userID = $_SESSION['userID']; // Get logged-in user's ID

    // Get unique subjects from learningMaterials
    $subjectQuery = "SELECT DISTINCT subjectCode FROM learningMaterials";
    $subjectStmt = $pdo->prepare($subjectQuery);
    $subjectStmt->execute();
    $subjects = $subjectStmt->fetchAll(PDO::FETCH_COLUMN);

    // Initialize subjects with default progress values
    $quizzes = [];
    foreach ($subjects as $subject) {
        $quizzes[$subject] = 0; // Set default progress to 0
    }

    $progressQuery = "SELECT subjectCode, SUM(views + downloads) AS totalActions
                    FROM userProgress 
                    WHERE userID = :userID 
                    GROUP BY subjectCode";
    $progressStmt = $pdo->prepare($progressQuery);
    $progressStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $progressStmt->execute();
    $progressData = $progressStmt->fetchAll(PDO::FETCH_ASSOC);

    // Function to calculate progress in steps
    function calculateProgress($actions) {
        if ($actions >= 10) return 35;
        if ($actions >= 8) return 30;
        if ($actions >= 6) return 25;
        if ($actions >= 4) return 20;
        if ($actions >= 2) return 10;
        return 0;
    }

    // Update progress values based on user history
    foreach ($progressData as $row) {
        if (isset($quizzes[$row['subjectCode']])) {
            $quizzes[$row['subjectCode']] = calculateProgress($row['totalActions']);
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="./css/styles.css">
        <title>TechIQ</title>
    </head>
    <body class="dashboardPage">
        <!---navbar-->
        <?php include 'user_backend/navbar.php';?>
        <!---end navbar-->

        <!-- Dashboard Section -->
        <section class="dashboard">
            <!-- Profile -->
            <div class="cover-photo" style="background: url('<?php echo $coverPhoto; ?>') center/cover no-repeat;"></div>
            <div class="profile-info">
                <div class="profile-pic" style="background: url('<?php echo $profilePic; ?>') center/cover no-repeat;"></div>                    
                <!--- PHP INPUTS --->
                <div class="profile-details">
                    <h2><?php echo htmlspecialchars($fullname); ?></h2>
                    <p><b>Username :</b> <?php echo htmlspecialchars($username); ?> | <b>LRN :</b> <?php echo htmlspecialchars($depedAcct); ?></p>
                    <p><b>Email :</b> <?php echo htmlspecialchars($email); ?></p>
                    <p class="bio">Web developer | Tech enthusiast | Lifelong learner</p>
                </div>
                    
                <div class="profile-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                    <button class="btn btn-danger" onclick="window.location.href='index.php'">Log Out</button>
                </div>
            </div>
            <!-- End Profile -->
        </section>

        <!-- Progress and Recents -->
        <section class="graphs-dynamic">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="progress-section col-md-5 text-center">
                    <h3 class="centered-heading">Progress</h3>
                    <div class="progress-chart">
                        <div class="progress-list d-flex align-items-end justify-content-center position-relative">
                            <?php if (!empty($quizzes)): ?>
                                <?php foreach ($quizzes as $subject => $progress): ?>
                                    <div class="progress-item text-center mx-3">
                                        <div class="progress vertical-bar">
                                            <div class="progress-bar" role="progressbar" style="height: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo $progress; ?>%
                                            </div>
                                        </div>
                                        <p class="x-tick"><?php echo htmlspecialchars($subject); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No subjects available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <!-- End graphs-dynamic Section -->

        <!--Call JS-->
        <script src="./js/scripts.js"></script>

        <!-- MODAL -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <!-- Edit Form -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group text-center">
                                <!-- Display current profile picture -->
                                <?php if (!empty($user['userPhoto'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['userPhoto']); ?>" class="img-thumbnail rounded-circle" width="150" height="150">
                                <?php else: ?>
                                <img src="images/profiles/default.png" class="img-thumbnail rounded-circle" width="150" height="150">
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                            <label for="userPhoto">Profile Picture</label>
                            <input type="file" class="form-control-file" id="userPhoto" name="userPhoto" accept="image/*">
                            </div>

                            <div class="form-group text-center">
                                <!-- Display current cover photo -->
                                <?php if (!empty($user['userCover'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['userCover']); ?>" class="img-thumbnail" width="300" height="100">
                                <?php else: ?>
                                    <img src="images/covers/cover.jpg" class="img-thumbnail" width="300" height="100">
                                <?php endif; ?>
                            </div>

                            <!-- File Upload Field -->
                            <div class="form-group">
                                <label for="userCover">Cover Photo</label>
                                <input type="file" class="form-control-file" id="userCover" name="userCover" accept="image/*">
                            </div>

                            <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="depedAcct">LRN</label>
                            <input type="text" class="form-control" id="depedAcct" name="depedAcct" value="<?php echo htmlspecialchars($depedAcct); ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>

                            <div class="form-group">
                            <button type="submit" name="saveProfile" class="btn btn-success">Save Profile</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
  </body>
</html>