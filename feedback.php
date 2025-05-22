<?php
session_start();

// Handle login/register logic before any output
include 'includes/auth.php';
include('includes/header.php');
include('includes/navbar.php');
include('includes/db.php');
include('includes/user.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize form fields
$formData = [
    'name' => '',
    'email' => '',
    'rating' => '',
    'content' => ''
];

$editFeedback = null;

// Handle Create or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : htmlspecialchars($_POST['email'] ?? '');
    $rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int)$_POST['rating'] : null;
    $content = htmlspecialchars($_POST['content'] ?? '');

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE feedback SET name = ?, email = ?, rating = ?, content = ? WHERE id = ?");
        $stmt->execute([$name, $email, $rating, $content, $id]);
        $_SESSION['success'] = 'Feedback updated successfully!';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO feedback (name, email, rating, content) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $rating, $content]);
            $_SESSION['success'] = 'Thank you for your feedback!';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
    }

    $editFeedback = null;
    $_POST = [];
    echo '<script>window.location.href = window.location.pathname;</script>';
    exit;
}

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->execute([$deleteId]);
    echo '<div class="alert alert-danger">Feedback deleted.</div>';
}

// Handle Edit
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM feedback WHERE id = ?");
    $stmt->execute([$editId]);
    $editFeedback = $stmt->fetch(PDO::FETCH_ASSOC);
}

$perPage = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, 3));
$offset = ($page - 1) * $perPage;
$totalStmt = $pdo->query("SELECT COUNT(*) FROM feedback");
$totalRows = $totalStmt->fetchColumn();
$totalPages = min(ceil($totalRows / $perPage), 3);
?>

<link rel="stylesheet" href="css/feedback.css">
<div class="container my-5">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <h2 class="section-title">Tell Us What You Think</h2>
    <div class="row">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM feedback ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-6 col-lg-4 mb-4">
                    <div class="feedback-card p-3 h-100 d-flex flex-column justify-content-between" style="min-height: 250px;">
                        <div>
                            <h5>' . htmlspecialchars($row['name'] ?? '') . '</h5>
                            <p class="text-muted small">' . htmlspecialchars($row['email'] ?? '') . '</p>';
            if (!empty($row['rating'])) {
                echo '<div class="mb-2">';
                for ($i = 1; $i <= 5; $i++) {
                    echo '<i class="bi ' . ($i <= $row['rating'] ? 'bi-star-fill text-warning' : 'bi-star') . '"></i>';
                }
                echo '</div>';
            }
            if (!empty($row['content'])) {
                echo '<p>' . htmlspecialchars($row['content']) . '</p>';
            }
            echo '</div>
                  <div>
                    <small class="text-muted">' . htmlspecialchars($row['created_at'] ?? '') . '</small><br>
                    <a href="?edit=' . $row['id'] . '" class="btn btn-sm btn-warning mt-2 me-2">Edit</a>
                    <a href="?delete=' . $row['id'] . '" class="btn btn-sm btn-danger mt-2" onclick="return confirm(\'Are you sure?\')">Delete</a>
                  </div>
                </div>
              </div>';
        }
        ?>
    </div>

    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <h4 class="mt-5 mb-3">Leave Your Feedback</h4>
    <div class="feedback-form-wrapper">
        <form method="POST" id="feedbackForm">
            <?php if ($editFeedback): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editFeedback['id']) ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editFeedback['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email (optional)</label>
                <?php if (isset($_SESSION['user_email'])): ?>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" readonly>
                <?php else: ?>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($editFeedback['email'] ?? '') ?>">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Rating</label>
                <div class="rating d-flex">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" hidden <?= (isset($editFeedback['rating']) && $editFeedback['rating'] == $i) ? 'checked' : '' ?>>
                        <label for="star<?= $i ?>" class="me-1" style="cursor:pointer;">
                            <i class="bi bi-star-fill fs-4 text-secondary" data-index="<?= $i ?>"></i>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Comment (optional)</label>
                <textarea name="content" rows="4" class="form-control"><?= htmlspecialchars($editFeedback['content'] ?? '') ?></textarea>
            </div>
            <button class="btn btn-primary"><?= $editFeedback ? 'Update Feedback' : 'Submit Feedback'; ?></button>
        </form>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.rating i');
    let selected = document.querySelector('input[name=rating]:checked')?.value || 0;

    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => highlightStars(index + 1));
        star.addEventListener('mouseout', () => highlightStars(selected));
        star.addEventListener('click', () => {
            selected = index + 1;
            document.getElementById('star' + selected).checked = true;
        });
    });

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            star.classList.toggle('text-warning', index < rating);
            star.classList.toggle('text-secondary', index >= rating);
        });
    }

    highlightStars(selected);
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php include('includes/footer.php'); ?>
