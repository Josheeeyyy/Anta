<?php
session_start();
include 'includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Anta Philippines</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/jogging.ico" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/index.css?v=<?= time(); ?>">
</head>

<body class="d-flex flex-column h-100">

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center mb-0">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center mb-0">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <main class="flex-shrink-0">
        <!-- Navigation -->
        <?php include 'includes/navbar.php'; ?>

        <!-- Static Homepage Banner -->
    <div class="homepage-banner text-center my-4">
        <img src="images/banner1.jpg" class="img-fluid" style="max-width: 1200px; width: 100%;" alt="Homepage Banner">
    </div>



        <!-- New Arrivals Section -->
        <div class="container my-5 featured-products">
            <h3 class="mb-4 fw-normal text-start">Newest In The Game</h3>
            <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $shoes = [
                        ['img' => 'images/Fnov5lsmen.jpg', 'hover_img' => 'images/Fnov5lsmenR.jpg', 'title' => 'NOVABLAST 5 LITE-SHOW', 'desc' => 'Men Shoes', 'price' => '$150'],
                        ['img' => 'images/Fnov5lswomen.jpg', 'hover_img' => 'images/Fnov5lswomenR.jpg', 'title' => 'NOVABLAST 5 LITE-SHOW', 'desc' => 'Women Shoes', 'price' => '$130'],
                        ['img' => 'images/Fgc27lsmen.jpg', 'hover_img' => 'images/Fgc27lsmenR.jpg', 'title' => 'GEL-CUMULUS 27 LITE-SHOW', 'desc' => 'Men Shoes', 'price' => '$110'],
                        ['img' => 'images/Fgc27lswomen.jpg', 'hover_img' => 'images/Fgc27lswomenR.jpg', 'title' => 'GEL-CUMULUS 27 LITE-SHOW', 'desc' => 'Women Shoes', 'price' => '$120'],
                        ['img' => 'images/Fgn27lsmen.jpg', 'hover_img' => 'images/Fgn27lsmenR.jpg', 'title' => 'GEL-NIMBUS 27 LITE-SHOW', 'desc' => 'Men Shoes', 'price' => '$125'],
                        ['img' => 'images/Fgn27lswomen.jpg', 'hover_img' => 'images/Fgn27lswomenR.jpg', 'title' => 'GEL-NIMBUS 27 LITE-SHOW', 'desc' => 'Women Shoes', 'price' => '$100'],
                        ['img' => 'images/Fgk31lsmen.jpg', 'hover_img' => 'images/Fgk31lsmenR.jpg', 'title' => 'GEL-KAYANO 31 LITE-SHOW', 'desc' => 'Men Shoes', 'price' => '$135'],
                        ['img' => 'images/Fgk31lswomen.jpg', 'hover_img' => 'images/Fgk31lswomenR.jpg', 'title' => 'GEL-KAYANO 31 LITE-SHOW', 'desc' => 'Women Shoes', 'price' => '$140'],
                    ];
                    $chunks = array_chunk($shoes, 4);
                    foreach ($chunks as $index => $chunk): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row">
                                <?php foreach ($chunk as $shoe): ?>
                                    <div class="col-md-3 mb-3">
                                        <div class="card h-100">
                                            <div class="card-img-wrapper">
                                                <img src="<?= $shoe['img']; ?>" class="card-img main-img" alt="<?= htmlspecialchars($shoe['title']); ?>">
                                                <img src="<?= $shoe['hover_img']; ?>" class="card-img hover-img" alt="<?= htmlspecialchars($shoe['title']); ?>">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($shoe['title']); ?></h5>
                                                <p class="card-text"><?= htmlspecialchars($shoe['desc']); ?></p>
                                                <p class="card-text text-primary fw-bold"><?= htmlspecialchars($shoe['price']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newArrivalsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"><i class="bi bi-chevron-left"></i></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newArrivalsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"><i class="bi bi-chevron-right"></i></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    <!-- Promo Banner Section -->
        <section class="promo-banner my-5">
    <!-- First banner -->
    <div class="position-relative mb-4">
        <img src="images/banner1.jpg" class="img-fluid w-100" alt="Promo 1">
    </div>

    <!-- New dual-banner layout -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="position-relative">
                <img src="images/banner2.jpg" class="img-fluid w-100" alt="Promo 2">
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative">
            <img src="images/banner3.jpg" class="img-fluid w-100" alt="Promo 3">
            </div>
        </div>
    </div>
    </section>

    <!-- Full-Width Triple Banner Section with Equal Spacing -->
    <section class="w-100 my-5">
    <div class="d-flex flex-wrap triple-banner-row">
        <div class="hover-box">
            <img src="images/banner4.jpg" class="img-fluid" alt="Sportstyle Apparel">
            <div class="hover-overlay d-flex justify-content-center align-items-center text-white fw-bold fs-4">
                SPORTSTYLE APPARELS
            </div>
        </div>
        <div class="hover-box">
            <img src="images/banner5.jpg" class="img-fluid" alt="Men's Shoes">
            <div class="hover-overlay d-flex justify-content-center align-items-center text-white fw-bold fs-4">
                SHOP MEN
            </div>
        </div>
        <div class="hover-box">
            <img src="images/banner6.jpg" class="img-fluid" alt="Women's Shoes">
            <div class="hover-overlay d-flex justify-content-center align-items-center text-white fw-bold fs-4">
                SHOP WOMEN
            </div>
        </div>
    </div>
    </section>


    <!-- Recommended Products Section -->
    <section class="recommended-products container my-5">
    <h3 class="text-center mb-4">Recommended</h3>
    <div class="row g-4">
        <!-- Product 1 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-img-wrapper">
                    <img src="images/Ftr2men.jpg" class="card-img main-img" alt="Product 1">
                    <img src="images/Ftr2menR.jpg" class="card-img hover-img" alt="Product 1 Hover">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">TIGER RUNNER II</h5>
                    <p class="card-text">Men's Sportstyle Shoes.</p>
                    <p class="fw-bold mt-auto">$49.99</p>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-img-wrapper">
                    <img src="images/Cwd9w.jpg" class="card-img main-img" alt="Product 2">
                    <img src="images/Cwd9wR.jpg" class="card-img hover-img" alt="Product 2 Hover">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">CALCETTO WD 9 WIDE</h5>
                    <p class="card-text">Unisex Futsal Shoes</p>
                    <p class="fw-bold mt-auto">$59.99</p>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-img-wrapper">
                    <img src="images/gt12wide.jpg" class="card-img main-img" alt="Product 3">
                    <img src="images/gt12wideR.jpg" class="card-img hover-img" alt="Product 3 Hover">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">GEL-TACTIC 12 WIDE</h5>
                    <p class="card-text">Unisex Indoor Shoes</p>
                    <p class="fw-bold mt-auto">$69.99</p>
                </div>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-img-wrapper">
                    <img src="images/atb4.jpg" class="card-img main-img" alt="Product 4">
                    <img src="images/atb4R.jpg" class="card-img hover-img" alt="Product 4 Hover">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">ATTACK HYPERBEAT 4</h5>
                    <p class="card-text">Unisex Table Tennis Shoes</p>
                    <p class="fw-bold mt-auto">$79.99</p>
                </div>
            </div>
        </div>
    </div>  
    </section>





    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Login/Register Modals -->
    <?php include 'includes/user.php'; ?>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scroll Footer JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let lastScrollTop = 0;
            const footer = document.getElementById('scroll-footer');

            window.addEventListener('scroll', function () {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                footer.classList.toggle('show-footer', scrollTop > lastScrollTop);
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            });
        });
    </script>
</body>
</html>
