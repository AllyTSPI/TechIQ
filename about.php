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
    <section class="about container mt-5">
        <div class="row" style = "margin-top: 5rem;">
            <!-- 1st Column: Title and Paragraph -->
            <div class="col-lg-4 col-md-12 mb-4 px-3">
                <h2>ABOUT</h2>
                <p>
                    <b>TechIQ</b> is an educational website offering students access to learning materials 
                    and gamified quizzes from platforms like Quizizz and Kahoot!. 
                    It combines study resources with interactive quizzes to make learning engaging 
                    and enjoyable, motivating students through fun, competitive challenges 
                    while reinforcing classroom lessons.
                </p>
            </div>

            <!-- 2nd Column: Picture and Description -->
            <div class="col-lg-4 col-md-6 mb-4 px-3">
                <div class="p-3">
                    <img src="images/c.jpg" alt="Description 1" class="img-fluid mb-3">
                    <p>
                        Offers a diverse range of learning materials tailored specifically for senior high school students.
                    </p>
                </div>
            </div>

            <!-- 3rd Column: Picture and Description -->
            <div class="col-lg-4 col-md-6 mb-4 px-3">
                <div class="p-3">
                    <img src="images/b.png" alt="Description 2" class="img-fluid mb-3">
                    <p>
                        Enhance Student Engagement with Interactive Quizzes from different gamified applications.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Dashboard Section -->

    <!--Call JS-->
    <script src="./js/scripts.js"></script>
  </body>
</html>