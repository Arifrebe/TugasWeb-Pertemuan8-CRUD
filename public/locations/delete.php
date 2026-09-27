<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['location_id'] ?? null;

    if ($id && ctype_digit((string)$id)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM locations WHERE location_id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['success'] = 'Lokasi berhasil dihapus.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lokasi tidak dapat dihapus karena masih digunakan oleh data inventaris.';
        }
    } else {
        $_SESSION['error'] = 'Data tidak valid.';
    }
}

header('Location: index.php');
exit;
