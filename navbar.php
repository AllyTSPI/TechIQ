<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
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

    <!-- User Dropdown Menu (Right Aligned) -->
    <div class="ml-auto">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> 
                    <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <?php if (isset($_SESSION['username'])): ?>
                        <button class="dropdown-item btn btn-danger" onclick="window.location.href='index.php'">Log Out</button>
                    <?php else: ?>
                        <a class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </div> 
</nav>
