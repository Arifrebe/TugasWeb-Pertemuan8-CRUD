<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$locations = $pdo->query("SELECT * FROM locations ORDER BY location_id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Lokasi</h2>
    <a href="create.php" class="btn btn-primary">+ Tambah Lokasi</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($locations) === 0): ?>
            <tr><td colspan="3" class="text-center">Belum ada data lokasi.</td></tr>
        <?php else: ?>
            <?php foreach ($locations as $loc): ?>
                <tr>
                    <td><?= (int)$loc['location_id'] ?></td>
                    <td><?= htmlspecialchars($loc['location_name']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= (int)$loc['location_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="delete.php" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                            <input type="hidden" name="location_id" value="<?= (int)$loc['location_id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
