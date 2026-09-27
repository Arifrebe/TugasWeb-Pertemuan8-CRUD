<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$sql = "SELECT inventories.inventory_id, inventories.item_name, inventories.quantity,
               categories.category_name, locations.location_name
        FROM inventories
        JOIN categories ON inventories.category_id = categories.category_id
        JOIN locations  ON inventories.location_id = locations.location_id
        ORDER BY inventories.inventory_id DESC";
$inventories = $pdo->query($sql)->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Inventaris</h2>
    <a href="create.php" class="btn btn-primary">+ Tambah Inventaris</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($inventories) === 0): ?>
            <tr><td colspan="6" class="text-center">Belum ada data inventaris.</td></tr>
        <?php else: ?>
            <?php foreach ($inventories as $item): ?>
                <tr>
                    <td><?= (int)$item['inventory_id'] ?></td>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= htmlspecialchars($item['category_name']) ?></td>
                    <td><?= htmlspecialchars($item['location_name']) ?></td>
                    <td><?= (int)$item['quantity'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= (int)$item['inventory_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="delete.php" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            <input type="hidden" name="inventory_id" value="<?= (int)$item['inventory_id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
