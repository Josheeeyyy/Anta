<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<!-- Navbar Custom CSS -->
<link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm no-border-navbar">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">
            <img src="images/anta.png" height="40" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="men.php">Mens</a></li>
                <li class="nav-item"><a class="nav-link" href="women.php">Womens</a></li>
                <li class="nav-item"><a class="nav-link" href="kids.php">Kids</a></li>
                <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <?php if (empty($_SESSION['user_email'])): ?>
                <div class="dropdown">
                    <button class="btn btn-link text-dark fs-4" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="dropdown">
                    <button class="btn btn-link text-dark fs-4" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><span class="dropdown-item-text"><?= htmlspecialchars($_SESSION['user_email']) ?></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php include 'includes/user.php'; ?>
