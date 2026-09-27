<?php
require_once __DIR__ . '/../../config/database.php';

$errors = [];
$id = $_GET['id'] ?? $_POST['category_id'] ?? null;

if (!$id || !ctype_digit((string)$id)) {
    $_SESSION['error'] = 'Data kategori tidak ditemukan.';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM categories WHERE category_id = :id");
$stmt->execute([':id' => $id]);
$category = $stmt->fetch();

if (!$category) {
    $_SESSION['error'] = 'Data kategori tidak ditemukan.';
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = trim($_POST['category_name'] ?? '');

    if ($categoryName === '') {
        $errors[] = 'Nama kategori wajib diisi.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET category_name = :category_name WHERE category_id = :id");
            $stmt->execute([':category_name' => $categoryName, ':id' => $id]);

            $_SESSION['success'] = 'Kategori berhasil diperbarui.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Nama kategori sudah ada atau terjadi kesalahan.';
        }
    } else {
        $category['category_name'] = $categoryName;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Edit Kategori</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="edit.php?id=<?= (int)$category['category_id'] ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
    <input type="hidden" name="category_id" value="<?= (int)$category['category_id'] ?>">
    <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="category_name" class="form-control"
               value="<?= htmlspecialchars($category['category_name']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
