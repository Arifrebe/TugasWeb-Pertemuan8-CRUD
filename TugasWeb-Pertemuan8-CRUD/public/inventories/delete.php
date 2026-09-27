<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['inventory_id'] ?? null;

    if ($id && ctype_digit((string)$id)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM inventories WHERE inventory_id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['success'] = 'Inventaris berhasil dihapus.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Terjadi kesalahan saat menghapus data.';
        }
    } else {
        $_SESSION['error'] = 'Data tidak valid.';
    }
}

header('Location: index.php');
exit;
