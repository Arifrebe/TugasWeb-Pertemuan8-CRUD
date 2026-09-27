<?php
require_once __DIR__ . '/../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $locationName = trim($_POST['location_name'] ?? '');

    if ($locationName === '') {
        $errors[] = 'Nama lokasi wajib diisi.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO locations (location_name) VALUES (:location_name)");
            $stmt->execute([':location_name' => $locationName]);

            $_SESSION['success'] = 'Lokasi berhasil ditambahkan.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Nama lokasi sudah ada atau terjadi kesalahan.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Tambah Lokasi</h2>

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
        <label class="form-label">Nama Lokasi</label>
        <input type="text" name="location_name" class="form-control"
               value="<?= htmlspecialchars($_POST['location_name'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
