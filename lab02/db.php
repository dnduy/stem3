<?php
/**
 * db.php – Kết nối CSDL MySQL
 * Dùng chung cho cả 3 bài lab
 * Đặt file này ở thư mục gốc: lab_login/db.php
 */

$host   = "localhost";
$user   = "root";
$pass   = "";          // Đổi thành mật khẩu MySQL của máy nếu có
$dbname = "lab_login";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
