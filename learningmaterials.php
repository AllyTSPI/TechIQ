<?php
    session_start();
    
    require 'config/connection.php';
    require './user_backend/showMaterials.php';
    require './user_backend/DLModule.php';
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
    <section class="dashboard container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Learning Materials</h2>
        <div class="input-group w-50">
          <input type="text" class="form-control" placeholder="Search files & folders">
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
      
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
          <table class="table table-striped table-bordered">
              <thead class="thead-dark">
                  <tr>
                      <th></th>
                      <th>File Name</th>
                      <th>Last Updated</th>
                      <th>Views</th>
                      <th>Favorites</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($learningMaterials as $material): ?>
                      <tr>
                          <td></td>
                          <td><?= htmlspecialchars($material['fileName']) ?></td>
                          <td><?= htmlspecialchars($material['dateAdded']) ?></td>
                          <td id="views-<?= $material['ID'] ?>">
                              <?= isset($material['views']) ? htmlspecialchars($material['views']) : '0' ?>
                          </td>
                          <td id="favorites-<?= $material['ID'] ?>">
                              <?= isset($material['favorites']) ? htmlspecialchars($material['favorites']) : '0' ?>
                          </td>
                          <td>
                              <a href="user_backend/viewMaterials.php?viewFileID=<?= urlencode($material['fileName']) ?>"
                                class="btn btn-sm btn-success download-btn" 
                                data-id="<?= htmlspecialchars($material['fileName']) ?>"
                                target="_blank">
                                <i class="fa fa-eye"></i>
                              </a>
                              <a href="learningmaterials.php?fileName=<?= urlencode($material['fileName']) ?>"
                                class="btn btn-sm btn-success download-btn" 
                                data-id="<?= htmlspecialchars($material['fileName']) ?>">
                                <i class="fa fa-download"></i>
                              </a>

                          </td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>
    </section>
    <!-- End Dashboard Section -->


    <!--Call JS-->
    <script src="./js/scripts.js"></script>
  </body>
</html>