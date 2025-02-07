<?php
session_start();
require 'config/connection.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];

// Handle profile update
if (isset($_POST['saveProfile'])) {
    $newFullname = $_POST['fullname'];
    $newDepedAcct = $_POST['depedAcct'];
    $newEmail = $_POST['email'];
    $profileImage = null;

    // Check if a file was uploaded
    if (isset($_FILES['userPhoto']) && $_FILES['userPhoto']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = file_get_contents($_FILES['userPhoto']['tmp_name']); // Convert image to binary
        $profileImage = $imageTmp;
    }

    // Update query with or without the image
    if ($profileImage !== null) {
        $updateQuery = "UPDATE users SET fullname = :fullname, depedAcct = :depedAcct, email = :email, userPhoto = :userPhoto WHERE username = :username";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':userPhoto', $profileImage, PDO::PARAM_LOB);
    } else {
        $updateQuery = "UPDATE users SET fullname = :fullname, depedAcct = :depedAcct, email = :email WHERE username = :username";
        $updateStmt = $pdo->prepare($updateQuery);
    }

    $updateStmt->bindParam(':fullname', $newFullname, PDO::PARAM_STR);
    $updateStmt->bindParam(':depedAcct', $newDepedAcct, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':username', $username, PDO::PARAM_STR);

    if ($updateStmt->execute()) {
        echo "";
    } else {
        echo "Error updating profile.";
    }
}

// Fetch the user's details including profile picture
$query = "SELECT fullname, username, depedAcct, email, userPhoto FROM users WHERE username = :username";
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

// Convert BLOB image to base64
$profilePic = !empty($user['userPhoto']) ? 'data:image/jpeg;base64,' . base64_encode($user['userPhoto']) : 'images/profiles/default.png';
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
    <nav class="navbar navbar-expand-lg navbar-light custom-nav">
      <a class="navbar-brand" href="index.php">TechIQ</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i> 
      </button>
    
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active mr-4">
            <a class="nav-link" href="about.php">About<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item mr-4">
            <a class="nav-link" href="learningmaterials.php">Learning Materials</a>
          </li>
          <li class="nav-item mr-4">
            <a class="nav-link" href="quizzes.php">Quizzes</a>
          </li>
          <li class="nav-item mr-4">
            <a class="nav-link" href="landing.php">Profile</a>
          </li>
        </ul>
      </div>
    </nav>
    <!---end navbar-->


    <!-- Dashboard Section -->
    <section class="dashboard">

        <!-- Profile -->
        <div class="cover-photo"></div>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
  Edit Profile
</button>
                      <button class="btn btn-danger" onclick="window.location.href='index.php'">Sign Out</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Profile -->
      </section>

    <!-- Progress and Recents -->
    <section class="graphs-dynamic">
    <div class="container mt-4">
    <div class="row">
        <!-- Progress Section (Left) -->
        <div class="progress-section col-md-5">
            <h3 class="centered-heading">Progress</h3>
            <div class="progress-chart">
                <div class="progress-list d-flex align-items-end position-relative">      
                    <?php
                        $quizzes = [
                            'Mathematics' => 80,
                            'English' => 60,
                            'Filipino' => 90,
                            'History' => 50,
                        ];
                    ?>
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
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="col-md-1 d-flex align-items-center justify-content-center">
            <div class="divider"></div>
        </div>

        <!-- Recents Section (Right) -->
        <div class="recents-section col-md-5">
    <h3 class="centered-heading">Recents</h3>
    <ul class="list-group no-border">
        <?php
            $recentModules = ['Mathematics', 'Science', 'History'];
        ?>
        <?php foreach ($recentModules as $module): ?>
            <li class="list-group-item">
                <label class="custom-checkbox">
                    <input type="checkbox" class="d-none"> <!-- Hide the default checkbox -->
                    <i class="fa fa-circle unchecked"></i> <!-- Unchecked icon -->
                    <i class="fa fa-check-circle checked"></i> <!-- Checked icon -->
                </label> 
                <?php echo htmlspecialchars($module); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>







    </div>
</div>
<!-- End Progress and Recents -->

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
              <img src="default-profile.png" class="img-thumbnail rounded-circle" width="150" height="150">
            <?php endif; ?>
          </div>

          <!-- File Upload Field -->
          <div class="form-group">
            <label for="userPhoto">Profile Picture</label>
            <input type="file" class="form-control-file" id="userPhoto" name="userPhoto" accept="image/*">
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