<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASICS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/run.ico" />

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/navbar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/footer.css?v=<?= time() ?>">
    
    <!-- Optional per-page CSS -->
    <?php if (isset($custom_style)): ?>
    <link rel="stylesheet" href="css/<?= htmlspecialchars($custom_style) ?>?v=<?= time() ?>">
<?php endif; ?>
</head>
<body>
