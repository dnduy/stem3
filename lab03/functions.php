<?php
/**
 * LAB 03 – functions.php
 * Thư viện hàm dùng chung cho toàn bộ project
 * Đặt ở thư mục gốc: lab_login/functions.php
 */
require_once __DIR__ . '/db.php';

// ═══════════════════════════════════════════════════════════
//  NHÓM 1 – Hàm tiện ích chung
// ═══════════════════════════════════════════════════════════

/** Chuyển hướng và dừng script */
function redirect($url) {
    header("Location: $url");
    exit();
}

/** Xuất chuỗi HTML an toàn (chống XSS) */
function e($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

/** Tạo slug từ tiếng Việt – vd: "Tin Tức" → "tin-tuc" */
function make_slug($str) {
    $str  = mb_strtolower(trim($str), 'UTF-8');
    $from = ['à','á','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ',
             'â','ấ','ậ','ầ','ẩ','ẫ','đ',
             'è','é','ẻ','ẽ','ẹ','ê','ế','ệ','ề','ể','ễ',
             'ì','í','ỉ','ĩ','ị',
             'ò','ó','ỏ','õ','ọ','ô','ố','ộ','ồ','ổ','ỗ',
             'ơ','ớ','ợ','ờ','ở','ỡ',
             'ù','ú','ủ','ũ','ụ','ư','ứ','ự','ừ','ử','ữ',
             'ỳ','ý','ỷ','ỹ','ỵ'];
    $to   = ['a','a','a','a','a','a','a','a','a','a','a',
             'a','a','a','a','a','a','d',
             'e','e','e','e','e','e','e','e','e','e','e',
             'i','i','i','i','i',
             'o','o','o','o','o','o','o','o','o','o','o',
             'o','o','o','o','o','o',
             'u','u','u','u','u','u','u','u','u','u','u',
             'y','y','y','y','y'];
    $str  = str_replace($from, $to, $str);
    $str  = preg_replace('/[^a-z0-9\s-]/', '', $str);
    $str  = preg_replace('/[\s-]+/', '-', $str);
    return trim($str, '-');
}

/** Cắt ngắn nội dung để hiển thị tóm tắt */
function excerpt($text, $length = 150) {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

/** Kiểm tra đăng nhập – nếu chưa thì redirect về login */
function require_login($base = '') {
    if (!isset($_SESSION['user'])) {
        redirect($base . 'login.php');
    }
}

/** Kiểm tra quyền admin */
function require_admin($base = '') {
    require_login($base);
    if ($_SESSION['user']['role'] !== 'admin') {
        redirect($base . 'dashboard.php');
    }
}

// ═══════════════════════════════════════════════════════════
//  NHÓM 2 – Hàm truy vấn CSDL (wrapper Prepared Statement)
// ═══════════════════════════════════════════════════════════

/**
 * Thực thi SELECT, trả về mảng tất cả kết quả
 * @param  string $sql    Câu SQL có dấu ? làm placeholder
 * @param  string $types  Chuỗi kiểu: 's'=string, 'i'=int, 'd'=double
 * @param  array  $params Mảng giá trị tương ứng
 * @return array
 */
function db_fetch_all($sql, $types = '', $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL Error: " . $conn->error . "<br>SQL: $sql");
    }
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}

/**
 * Thực thi SELECT, trả về đúng 1 hàng (hoặc null)
 */
function db_fetch_one($sql, $types = '', $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL Error: " . $conn->error . "<br>SQL: $sql");
    }
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

/**
 * Thực thi INSERT / UPDATE / DELETE
 * @return bool true nếu thành công
 */
function db_execute($sql, $types, $params) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL Error: " . $conn->error . "<br>SQL: $sql");
    }
    $stmt->bind_param($types, ...$params);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/** Lấy ID của bản ghi vừa INSERT */
function db_last_id() {
    global $conn;
    return $conn->insert_id;
}

// ═══════════════════════════════════════════════════════════
//  NHÓM 3 – Hàm nghiệp vụ: Category
// ═══════════════════════════════════════════════════════════

function get_all_categories() {
    return db_fetch_all("SELECT * FROM categories ORDER BY id");
}

function get_category_by_id($id) {
    return db_fetch_one("SELECT * FROM categories WHERE id = ?", 'i', [$id]);
}

function get_category_by_slug($slug) {
    return db_fetch_one("SELECT * FROM categories WHERE slug = ?", 's', [$slug]);
}

function create_category($name, $slug, $desc) {
    return db_execute(
        "INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)",
        'sss', [$name, $slug, $desc]
    );
}

function update_category($id, $name, $slug, $desc) {
    return db_execute(
        "UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?",
        'sssi', [$name, $slug, $desc, $id]
    );
}

function delete_category($id) {
    return db_execute("DELETE FROM categories WHERE id = ?", 'i', [$id]);
}

function count_posts_in_category($cat_id) {
    $row = db_fetch_one(
        "SELECT COUNT(*) AS total FROM posts WHERE category_id = ?", 'i', [$cat_id]
    );
    return (int)$row['total'];
}

// ═══════════════════════════════════════════════════════════
//  NHÓM 4 – Hàm nghiệp vụ: Post
// ═══════════════════════════════════════════════════════════

/** Lấy toàn bộ bài viết kèm tên chuyên mục và tên tác giả */
function get_all_posts() {
    return db_fetch_all(
        "SELECT p.*, c.name AS cat_name, c.slug AS cat_slug, u.full_name AS author_name
         FROM posts p
         JOIN categories c ON p.category_id = c.id
         JOIN users      u ON p.author_id   = u.id
         ORDER BY p.created_at DESC"
    );
}

/** Lấy bài viết đã đăng theo chuyên mục */
function get_posts_by_category($cat_id) {
    return db_fetch_all(
        "SELECT p.*, c.name AS cat_name, c.slug AS cat_slug, u.full_name AS author_name
         FROM posts p
         JOIN categories c ON p.category_id = c.id
         JOIN users      u ON p.author_id   = u.id
         WHERE p.category_id = ? AND p.status = 'published'
         ORDER BY p.created_at DESC",
        'i', [$cat_id]
    );
}

/** Lấy tất cả bài đã published (trang công khai) */
function get_published_posts() {
    return db_fetch_all(
        "SELECT p.*, c.name AS cat_name, c.slug AS cat_slug, u.full_name AS author_name
         FROM posts p
         JOIN categories c ON p.category_id = c.id
         JOIN users      u ON p.author_id   = u.id
         WHERE p.status = 'published'
         ORDER BY p.created_at DESC"
    );
}

function get_post_by_id($id) {
    return db_fetch_one("SELECT * FROM posts WHERE id = ?", 'i', [$id]);
}

function get_post_by_slug($slug) {
    return db_fetch_one(
        "SELECT p.*, c.name AS cat_name, c.slug AS cat_slug, u.full_name AS author_name
         FROM posts p
         JOIN categories c ON p.category_id = c.id
         JOIN users      u ON p.author_id   = u.id
         WHERE p.slug = ? AND p.status = 'published'",
        's', [$slug]
    );
}

function create_post($cat_id, $title, $slug, $content, $status, $author_id) {
    return db_execute(
        "INSERT INTO posts (category_id, title, slug, content, status, author_id)
         VALUES (?, ?, ?, ?, ?, ?)",
        'issssi', [$cat_id, $title, $slug, $content, $status, $author_id]
    );
}

function update_post($id, $cat_id, $title, $slug, $content, $status) {
    return db_execute(
        "UPDATE posts SET category_id=?, title=?, slug=?, content=?, status=? WHERE id=?",
        'issssi', [$cat_id, $title, $slug, $content, $status, $id]
    );
}

function delete_post($id) {
    return db_execute("DELETE FROM posts WHERE id = ?", 'i', [$id]);
}
