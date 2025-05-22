<?php
session_start();
include 'includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kids' Products</title>

    <link rel="icon" type="image/x-icon" href="assets/run.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="css/products.css?v=<?= time(); ?>" />
</head>

<body class="d-flex flex-column min-vh-100">

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

<?php include 'includes/navbar.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
$limit = 9;
$maxPages = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($maxPages, $page));
$start = ($page - 1) * $limit;

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$params = [];
$sql = "SELECT * FROM products WHERE gender = 'Kids'";

if ($searchTerm !== '') {
    $sql .= " AND name LIKE :search";
    $params[':search'] = '%' . $searchTerm . '%';
}

$sql .= " LIMIT 27";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$allProducts = $stmt->fetchAll();
$products = array_slice($allProducts, $start, $limit);
?>

<main class="flex-fill">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h2 class="section-title m-0">Kids' Products</h2>
            <form method="GET" class="search-bar-form mt-2 mt-md-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="<?= htmlspecialchars($searchTerm) ?>" />
                    <button class="btn btn-dark" type="submit">Go</button>
                </div>
            </form>
        </div>

        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 product-card">
                            <!-- Carousel -->
                            <div id="carousel<?= $product['id'] ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $images = [$product['image'], $product['hover_image']];
                                    $hasActive = false;
                                    foreach ($images as $index => $img):
                                        if (!empty($img)):
                                    ?>
                                    <div class="carousel-item <?= !$hasActive ? 'active' : '' ?>">
                                        <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100 carousel-img" alt="Product image <?= $index + 1 ?>">
                                    </div>
                                    <?php
                                            $hasActive = true;
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                                <?php if ($hasActive && count(array_filter($images)) > 1): ?>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="text-primary fw-bold">$<?= htmlspecialchars($product['price']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No products found.</p>
                </div>
            <?php endif; ?>
        </div>

        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/user.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastScrollTop = 0;
        const footer = document.getElementById('scroll-footer');

        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                footer.classList.add('show-footer');
            } else {
                footer.classList.remove('show-footer');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    });
</script>

</body>
</html>
