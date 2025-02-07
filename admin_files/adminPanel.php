<?php
    session_start();

    require '../config/connection.php';
    require '../admin_php/addSubject.php';
    require '../admin_php/showAdmin.php';
    require '../admin_php/showUsers.php';
    require '../admin_php/uploadMaterial.php';
    require '../admin_php/downloadMaterial.php';
    require '../admin_php/addQuizForm.php';

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['active_section'] = 'list-of-subjects';
    }

    // Default section
    $activeSection = $_SESSION['active_section'] ?? 'quizzes';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-styles.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="text-center">
        <!-- Profile Image -->
        <img src="../images/profiles/default.png" alt="Profile Image" class="profile-image">
        
        <!-- Upload New Photo Button -->
        <!-- <button class="upload-btn">Upload New Photo</button> -->
    </div>
    
    <h3 class="text-center text-white mt-3">ADMIN</h3>

    <ul class="nav flex-column">
        <!-- <li class="nav-item">
            <a class="nav-link text-white" href="#" id="dashboard">Dashboard</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link text-white" href="#" id="quizzes">Quizzes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#" id="learning-materials">Learning Materials</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#" id="users">Users</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link text-white dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                <a class="dropdown-item" href="#" id="list-of-admins">List of Admin accounts</a>
                <a class="dropdown-item" href="#" id="list-of-subjects">List of Subjects</a>
            </div>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!-- Left Side Message (Plain Text) -->
        <span class="navbar-brand">Welcome to TechIQ admin panel!</span>

        <!-- Toggler Button (for mobile view) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Page Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Content -->
                <div class="dashboard-content">
                    <h4>Dashboard</h4>
                    <p>Welcome to your Admin Panel. Here you can manage and monitor activities and actions.</p>

                    <!-- Example Card for Activities -->
                    <div class="card">
                        <div class="card-header">
                            Activities
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>
                            <p class="card-text">Monitor the latest activities here. You can perform actions like approve or delete items.</p>
                            <a href="#" class="btn btn-primary">View Activities</a>
                        </div>
                    </div>

                    <!-- Example Card for Actions -->
                    <div class="card mt-4">
                        <div class="card-header">
                            Actions
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Manage Actions</h5>
                            <p class="card-text">Here, you can perform actions such as updating settings or managing users.</p>
                            <a href="#" class="btn btn-success">View Actions</a>
                        </div>
                    </div>
                </div>

                <!-- Quizzes Content -->
                <div class="quiz-content">
                    <h4>Quizzes</h4>

                    <form id="addQuizForm" action="../admin_files/adminPanel.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <input type="text" name="quizCode" id="quizCode" class="form-control" placeholder="Quiz Code" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="subjectName" id="subjectName" class="form-control" placeholder="Subject Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="quizLink" id="quizLink" class="form-control" placeholder="Quiz Link" required>
                        </div>

                        <button type="submit" class="btn btn-success">Add Quiz</button>

                    </form>
                    
                    <br>
                    <!-- Quizzes Table -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                <tr>
                                    <th></th>
                                    <th>Quiz Code</th>
                                    <th>Subject Name</th>
                                    <th>Quiz Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <td><?= htmlspecialchars($quiz['ID']) ?></td>
                                    <td><?= htmlspecialchars($quiz['quizCode']) ?></td>
                                    <td><?= htmlspecialchars($quiz['subjectName']) ?></td>
                                    <td><?= htmlspecialchars($quiz['quizLink']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Learning Materials Content -->
                <div class="learning-materials-content">
                    <h4>Learning Materials</h4>
                    <!-- Add Learning Material Form -->
                    <form id="addLearningMaterialForm" action="../admin_php/uploadMaterial.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" name="subjectCode" id="subjectCode" class="form-control" placeholder="Subject Code" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="moduleName" id="moduleName" class="form-control" placeholder="Module Name" required>
                        </div>

                        <!-- File input with button beside it -->
                        <div class="form-group">
                            <label for="attachment">Upload Attachment (PDF, DOCX, PPT)</label>
                            <div class="input-group">
                                <input type="file" name="attachment" id="attachment" class="form-control border-0 shadow-none" accept=".pdf,.docx,.ppt,.pptx" required>
                                <button type="submit" class="btn btn-success">Upload Material</button>
                            </div>
                        </div>
                    </form>

                    <br>
                    <!-- Learning Materials Table -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                <tr>
                                    <th>ID</th>
                                    <th>Subject Code</th>
                                    <th>Module Name</th>
                                    <th>Date Created</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($learningMaterials as $material): ?>
                                <tr>
                                    <td><?= htmlspecialchars($material['ID']) ?></td>
                                    <td><?= htmlspecialchars($material['subjectCode']) ?></td>
                                    <td><?= htmlspecialchars($material['moduleName']) ?></td>
                                    <td><?= htmlspecialchars($material['dateAdded']) ?></td>
                                    <td>
                                        <a href="../admin_php/downloadMaterial.php?ID=<?= $material['ID'] ?>" class="btn btn-primary btn-sm">
                                            <?= htmlspecialchars($material['fileName']) ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Content -->
                <div class="users-content">
                    <h4>Users</h4>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">LRN</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Last Login Date</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['userID']) ?></td>
                                    <td><?= htmlspecialchars($user['fullname']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['depedAcct']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['lastLoginDate']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- List of Admins Content -->
                <div class="list-of-admins-content">
                    <h4>List of Admins</h4>
                    <br>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Admin Name</th>
                                    <th scope="col">Last Login Date</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                                <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($admin['id']) ?></td>
                                    <td><?= htmlspecialchars($admin['name']) ?></td>
                                    <td><?= htmlspecialchars($admin['lastLoginDate']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                

                <!-- List of Subjects Content -->
                <div class="list-of-subjects-content">
                    <h4>List of Subjects</h4>

                    <!-- Add Subject Form -->
                    <form id="addSubjectForm" action="adminPanel.php" method="POST">
                        <input type="text" name="subjectCode" placeholder="Subject Code" required>
                        <input type="text" name="subjectName" placeholder="Subject Name" required>
                        <button type="submit" class="btn btn-success">Add Subject</button>
                    </form>

                    <br>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                <tr>
                                    <th scope="col">Subject Code</th>
                                    <th scope="col">Subject Name</th>
                                    <th scope="col">Date Added</th>
                                    <th scope="col">Added By</th>
                                    <!--<th scope="col">Actions</th>-->
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                                <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td><?= htmlspecialchars($subject['subjectCode']) ?></td>
                                    <td><?= htmlspecialchars($subject['subjectName']) ?></td>
                                    <td><?= htmlspecialchars($subject['dateAdded']) ?></td>
                                    <td><?= htmlspecialchars($subject['addedBy']) ?></td>
                                    <!-- <td>
                                        <a href="#" class="btn btn-info btn-sm edit-btn" data-code="">Edit</a>
                                        <a href="deleteSubject.php?code=" class="btn btn-danger btn-sm">Delete</a>
                                    </td> -->
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Hide all sections
        $('.quiz-content, .learning-materials-content, .users-content, .list-of-admins-content, .list-of-subjects-content').hide();

        // Use PHP session variable to determine which section to show
        var activeSection = "<?= $activeSection ?>";
        if (activeSection === "list-of-subjects") {
            $('.list-of-subjects-content').show();
        } else {
            $('.quiz-content').show(); // Default to Dashboard
        }

        // Handle sidebar clicks
        $('#quizzes').click(function() {
            setActiveSection('quiz-content');
        });

        // $('#dashboard').click(function() {
        //     setActiveSection('dashboard-content');
        // });

        $('#learning-materials').click(function() {
            setActiveSection('learning-materials-content');
        });

        $('#users').click(function() {
            setActiveSection('users-content');
        });
        
        $('#list-of-admins').click(function() {
            setActiveSection('list-of-admins-content');
        });

        $('#list-of-subjects').click(function() {
            setActiveSection('list-of-subjects-content');
        });


        function setActiveSection(sectionClass) {
            // Hide all sections
            $(' .activities-content, .quiz-content, .learning-materials-content, .users-content, .list-of-admins-content, .list-of-subjects-content').hide();
            // Show selected section
            $('.' + sectionClass).show();
        }
    });





</script>
</body>
</html>
