<?php
require_once __DIR__ . '/../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = trim($_POST['category_name'] ?? '');

    if ($categoryName === '') {
        $errors[] = 'Nama kategori wajib diisi.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
            $stmt->execute([':category_name' => $categoryName]);

            $_SESSION['success'] = 'Kategori berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Nama kategori sudah ada atau terjadi kesalahan.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Tambah Kategori</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="create.php" method="POST" class="bg-white p-4 rounded shadow-sm">
    <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="category_name" class="form-control"
               value="<?= htmlspecialchars($_POST['category_name'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
