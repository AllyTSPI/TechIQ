<?php
    session_start();
    
    require 'connection.php';
    require 'materials.php';
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
                      <th>File Name</th>
                      <th>Last Updated</th>
                      <th>Views</th>
                      <th>Downloads</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($learningMaterials as $material): ?>
                      <tr>
                          <td><?= htmlspecialchars($material['fileName']) ?></td>
                          <td><?= htmlspecialchars($material['dateAdded']) ?></td>
                          <td><?= htmlspecialchars($material['views']) ?></td>
                          <td><?= htmlspecialchars($material['downloads']) ?></td>
                          <td>
                              <a href="learningMaterials.php?viewFileID=<?= urlencode($material['fileName']) ?>" 
                                class="btn btn-sm view-btn"
                                data-id="<?= $material['ID'] ?>"
                                data-file="<?= urlencode($material['fileName']) ?>"
                                target="_blank">
                                    <i class="fa fa-eye"></i>
                              </a>
                              <a href="learningMaterials.php?fileName=<?= urlencode($material['fileName']) ?>"
                                class="btn btn-sm download-btn" 
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