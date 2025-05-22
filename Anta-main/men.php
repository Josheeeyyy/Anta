<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Men's Products</title>

  <link rel="icon" type="image/x-icon" href="assets/jogging.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="css/products.css?v=<?= time(); ?>">

  <style>
    /* Subtle zoom effect on image hover */
    .product-card img.product-image {
      transition: transform 0.3s ease, filter 0.3s ease;
    }
    .product-card:hover img.product-image {
      transform: scale(1.05);
      filter: brightness(1.1);
      cursor: pointer;
    }
  </style>
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

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
      <?php
      try {
          $stmt = $pdo->prepare("SELECT * FROM products WHERE gender = 'Men' ORDER BY created_at DESC LIMIT 8");
          $stmt->execute();
          foreach ($stmt as $product):
              // Use image path as stored in DB directly
              $imagePath = !empty($product['image']) ? $product['image'] : 'assets/images/placeholder.jpg';
              ?>
              <div class="col">
                  <div class="card h-100 product-card shadow-sm">
                      <img 
                        src="<?= htmlspecialchars($imagePath); ?>" 
                        alt="<?= htmlspecialchars($product['name']); ?>" 
                        class="card-img-top product-image" 
                        onerror="this.onerror=null;this.src='assets/images/placeholder.jpg';" 
                      />
                      <div class="card-body d-flex flex-column text-center">
                          <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                          <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                          <p class="fw-bold text-primary mt-auto">$<?= number_format($product['price'], 2); ?></p>
                      </div>
                  </div>
              </div>
          <?php endforeach;
      } catch (PDOException $e) {
          echo "<div class='alert alert-danger text-center'>Error fetching products: " . htmlspecialchars($e->getMessage()) . "</div>";
      }
      ?>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
<?php include('includes/user.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
