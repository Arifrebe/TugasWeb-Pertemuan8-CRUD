<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['category_id'] ?? null;

    if ($id && ctype_digit((string)$id)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['success'] = 'Kategori berhasil dihapus.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Kategori tidak dapat dihapus karena masih digunakan oleh data inventaris.';
        }
    } else {
        $_SESSION['error'] = 'Data tidak valid.';
    }
}

header('Location: index.php');
exit;
