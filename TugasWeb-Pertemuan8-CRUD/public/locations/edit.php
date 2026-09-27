<?php
require_once __DIR__ . '/../../config/database.php';

$errors = [];
$id = $_GET['id'] ?? $_POST['location_id'] ?? null;

if (!$id || !ctype_digit((string)$id)) {
    $_SESSION['error'] = 'Data lokasi tidak ditemukan.';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM locations WHERE location_id = :id");
$stmt->execute([':id' => $id]);
$location = $stmt->fetch();

if (!$location) {
    $_SESSION['error'] = 'Data lokasi tidak ditemukan.';
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $locationName = trim($_POST['location_name'] ?? '');

    if ($locationName === '') {
        $errors[] = 'Nama lokasi wajib diisi.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE locations SET location_name = :location_name WHERE location_id = :id");
            $stmt->execute([':location_name' => $locationName, ':id' => $id]);

            $_SESSION['success'] = 'Lokasi berhasil diperbarui.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Nama lokasi sudah ada atau terjadi kesalahan.';
        }
    } else {
        $location['location_name'] = $locationName;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Edit Lokasi</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="edit.php?id=<?= (int)$location['location_id'] ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
    <input type="hidden" name="location_id" value="<?= (int)$location['location_id'] ?>">
    <div class="mb-3">
        <label class="form-label">Nama Lokasi</label>
        <input type="text" name="location_name" class="form-control"
               value="<?= htmlspecialchars($location['location_name']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
