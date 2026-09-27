<?php
require_once __DIR__ . '/../../config/database.php';

$errors = [];
$id = $_GET['id'] ?? $_POST['inventory_id'] ?? null;

if (!$id || !ctype_digit((string)$id)) {
    $_SESSION['error'] = 'Data inventaris tidak ditemukan.';
    header('Location: index.php');
    exit;
}

$categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name")->fetchAll();
$locations  = $pdo->query("SELECT location_id, location_name FROM locations ORDER BY location_name")->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM inventories WHERE inventory_id = :id");
$stmt->execute([':id' => $id]);
$inventory = $stmt->fetch();

if (!$inventory) {
    $_SESSION['error'] = 'Data inventaris tidak ditemukan.';
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName   = trim($_POST['item_name'] ?? '');
    $quantity   = $_POST['quantity'] ?? '';
    $categoryId = $_POST['category_id'] ?? '';
    $locationId = $_POST['location_id'] ?? '';

    if ($itemName === '') {
        $errors[] = 'Nama barang wajib diisi.';
    }
    if ($quantity === '' || !ctype_digit((string)$quantity)) {
        $errors[] = 'Jumlah harus berupa angka yang valid.';
    }
    if ($categoryId === '' || !ctype_digit((string)$categoryId)) {
        $errors[] = 'Kategori wajib dipilih.';
    }
    if ($locationId === '' || !ctype_digit((string)$locationId)) {
        $errors[] = 'Lokasi wajib dipilih.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE inventories
                                    SET item_name = :item_name, quantity = :quantity,
                                        category_id = :category_id, location_id = :location_id
                                    WHERE inventory_id = :id");
            $stmt->execute([
                ':item_name'   => $itemName,
                ':quantity'    => (int)$quantity,
                ':category_id' => (int)$categoryId,
                ':location_id' => (int)$locationId,
                ':id'          => $id,
            ]);

            $_SESSION['success'] = 'Inventaris berhasil diperbarui.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Terjadi kesalahan saat memperbarui data.';
        }
    } else {
        // supaya form tetap menampilkan input yang baru diketik user
        $inventory['item_name']   = $itemName;
        $inventory['quantity']    = $quantity;
        $inventory['category_id'] = $categoryId;
        $inventory['location_id'] = $locationId;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Edit Inventaris</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="edit.php?id=<?= (int)$inventory['inventory_id'] ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
    <input type="hidden" name="inventory_id" value="<?= (int)$inventory['inventory_id'] ?>">
    <div class="mb-3">
        <label class="form-label">Nama Barang</label>
        <input type="text" name="item_name" class="form-control"
               value="<?= htmlspecialchars($inventory['item_name']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input type="number" name="quantity" class="form-control" min="0"
               value="<?= htmlspecialchars($inventory['quantity']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['category_id'] ?>"
                    <?= ($inventory['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Lokasi</label>
        <select name="location_id" class="form-select">
            <?php foreach ($locations as $loc): ?>
                <option value="<?= (int)$loc['location_id'] ?>"
                    <?= ($inventory['location_id'] == $loc['location_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($loc['location_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
