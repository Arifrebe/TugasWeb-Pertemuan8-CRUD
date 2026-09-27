<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$categories = $pdo->query("SELECT * FROM categories ORDER BY category_id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Kategori</h2>
    <a href="create.php" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($categories) === 0): ?>
            <tr><td colspan="3" class="text-center">Belum ada data kategori.</td></tr>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= (int)$cat['category_id'] ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= (int)$cat['category_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="delete.php" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            <input type="hidden" name="category_id" value="<?= (int)$cat['category_id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
