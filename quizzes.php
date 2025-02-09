<?php
    
    require 'config/connection.php';

    try {
        // Prepare the SQL query to fetch quiz data
        $sql = "SELECT subjectName, quizLink, quizIcon FROM quizzess ORDER BY dateCreated DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // Fetch all quizzes
        $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching quizzes: " . $e->getMessage());
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

        <!-- Quizzes Section -->
        <section class="quizzes container mt-5">
    <div class="row">
        <?php
        if (!empty($quizzes)) {
            foreach ($quizzes as $quiz) {
                ?>
                <div class="col-lg-4 col-md-6 mb-4 px-3">
                    <div class="p-3 custom-border">
                    <img src="data:image/png;base64,<?php echo base64_encode($quiz['quizIcon']); ?>" 
                    alt="<?php echo htmlspecialchars($quiz['subjectName']); ?>" class="img-fluid mb-3">
                        <p class="custom-paragraph"><?php echo htmlspecialchars($quiz['subjectName']); ?></p>
                        <a href="<?php echo htmlspecialchars($quiz['quizLink']); ?>" target="_blank" class="btn btn-custom">Take Quiz</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No quizzes available.</p>";
        }
        ?>
    </div>
</section>

        <!-- End  Quizzes Section  -->

        <!--Call JS-->
        <script src="./js/scripts.js"></script>
    </body>
</html>