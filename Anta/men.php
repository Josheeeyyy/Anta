<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';

// Fetch up to 6 men's products
$sql = "SELECT * FROM products WHERE gender = 'Men' LIMIT 6";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Men's Products</title>

  <link rel="icon" type="image/x-icon" href="assets/jogging.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="css/products.css?v=<?= time(); ?>">
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

<?php include('includes/navbar.php'); ?>

<main class="flex-fill">
  <div class="container my-5">
    <div class="text-center mb-4">
      <h2 class="section-title">Move with Confidence Using Anta Philippines’ Sportswear for Men</h2>
      <p class="section-subtitle">Our men’s sportswear offers exceptional comfort and elevates your athletic performance.</p>
    </div>

    <div class="row">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 product-card shadow-hover">

              <?php
              // Determine the image path
              $imagePath = $product['image'];

              // If only filename is stored, prefix the folder
              if (!str_contains($imagePath, 'images/')) {
                  $imagePath = 'images/men/' . $imagePath;
              }
              ?>

              <img 
                src="<?= htmlspecialchars($imagePath) ?>" 
                class="card-img-top product-image"
                alt="<?= htmlspecialchars($product['name']) ?>"
                onerror="this.onerror=null;this.src='assets/images/placeholder.jpg';"
              />

              <div class="card-body text-center">
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
  </div>
</main>

<?php include('includes/footer.php'); ?>
<?php include('includes/user.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
