<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

$totalInventories = $pdo->query("SELECT COUNT(*) AS total FROM inventories")->fetch()['total'];
$totalCategories  = $pdo->query("SELECT COUNT(*) AS total FROM categories")->fetch()['total'];
$totalLocations   = $pdo->query("SELECT COUNT(*) AS total FROM locations")->fetch()['total'];
?>

<h2 class="mb-4">Dashboard</h2>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Inventaris</h5>
                <p class="card-text fs-2"><?= (int)$totalInventories ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Kategori</h5>
                <p class="card-text fs-2"><?= (int)$totalCategories ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Total Lokasi</h5>
                <p class="card-text fs-2"><?= (int)$totalLocations ?></p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
