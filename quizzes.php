<?php
    
    require 'connection.php';

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
        <?php include 'navbar.php';?>
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