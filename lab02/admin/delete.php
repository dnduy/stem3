<?php
/**
 * LAB 02 – admin/delete.php
 * Xóa người dùng (không cho phép tự xóa mình)
 */
session_start();
require "../db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);

// Không cho tự xóa chính mình
if ($id === (int)$_SESSION['user']['id']) {
    header("Location: index.php?msg=self");
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php?msg=deleted");
exit();
