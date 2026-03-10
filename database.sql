-- ============================================================
--  FILE SQL DÙNG CHUNG CHO CẢ 3 BÀI LAB PHP
--  Môn: Lập trình Web – PHP + MySQL
--  Hướng dẫn: Import file này vào phpMyAdmin
--             Database → Import → Chọn file → Go
-- ============================================================

-- Tạo và chọn database
CREATE DATABASE IF NOT EXISTS lab_login
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE lab_login;

-- ============================================================
--  LAB 01 & 02 – Bảng USERS
-- ============================================================

DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    username     VARCHAR(50)  NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    full_name    VARCHAR(100) DEFAULT NULL,
    email        VARCHAR(100) UNIQUE,
    role         ENUM('admin','user') DEFAULT 'user',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tài khoản admin – password: Admin@123
INSERT INTO users (username, password, full_name, email, role) VALUES
(
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Quản trị viên',
    'admin@school.edu.vn',
    'admin'
),
-- Tài khoản user thường – password: 123456
(
    'sv01',
    '$2y$10$TKh8H1.PBxoIBSKq5fL0meHJJLB3UVSYhVGAbxhXeNrpYGK9Kc0sO',
    'Sinh viên 01',
    'sv01@school.edu.vn',
    'user'
),
(
    'sv02',
    '$2y$10$TKh8H1.PBxoIBSKq5fL0meHJJLB3UVSYhVGAbxhXeNrpYGK9Kc0sO',
    'Sinh viên 02',
    'sv02@school.edu.vn',
    'user'
);

-- ============================================================
--  LAB 03 – Bảng CATEGORIES và POSTS
-- ============================================================

CREATE TABLE categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL UNIQUE,
    description TEXT         DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posts (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    category_id  INT          NOT NULL,
    title        VARCHAR(200) NOT NULL,
    slug         VARCHAR(200) NOT NULL UNIQUE,
    content      TEXT         NOT NULL,
    thumbnail    VARCHAR(255) DEFAULT NULL,
    status       ENUM('published','draft') DEFAULT 'draft',
    author_id    INT          NOT NULL,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (author_id)   REFERENCES users(id)      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dữ liệu mẫu – chuyên mục
INSERT INTO categories (name, slug, description) VALUES
('Công nghệ',  'cong-nghe',  'Tin tức về công nghệ, AI, lập trình'),
('Giáo dục',   'giao-duc',   'Thông tin học bổng, tuyển sinh'),
('Thể thao',   'the-thao',   'Kết quả bóng đá và các môn thể thao');

-- Dữ liệu mẫu – bài viết (author_id = 1 là admin)
INSERT INTO posts (category_id, title, slug, content, status, author_id) VALUES
(
    1,
    'PHP 8.3 ra mắt với nhiều tính năng mới',
    'php-83-ra-mat',
    'PHP 8.3 mang lại nhiều cải tiến đáng kể về hiệu năng và cú pháp. Một trong những điểm nổi bật là hỗ trợ typed class constants, giúp lập trình viên kiểm soát kiểu dữ liệu tốt hơn. Ngoài ra, json_validate() được thêm vào để kiểm tra chuỗi JSON mà không cần decode. Đây là bản cập nhật quan trọng mà mọi lập trình viên PHP nên nắm bắt.',
    'published',
    1
),
(
    1,
    'MySQL 9.0 – Những điểm đáng chú ý',
    'mysql-90-diem-dang-chu-y',
    'MySQL 9.0 được phát hành với nhiều tính năng hấp dẫn, bao gồm cải tiến về hiệu suất truy vấn và hỗ trợ tốt hơn cho JSON. Phiên bản này cũng tăng cường bảo mật với các cơ chế xác thực mới. Đặc biệt, optimizer được cải thiện đáng kể giúp các câu truy vấn phức tạp chạy nhanh hơn tới 30%.',
    'published',
    1
),
(
    2,
    'Học bổng du học Nhật Bản 2025',
    'hoc-bong-nhat-ban-2025',
    'Chương trình học bổng MEXT 2025 dành cho sinh viên Việt Nam đã chính thức mở đơn. Học bổng bao gồm toàn bộ học phí, sinh hoạt phí 117,000 yên/tháng và vé máy bay khứ hồi. Ứng viên cần có bằng tốt nghiệp THPT loại khá trở lên và đáp ứng yêu cầu tiếng Nhật hoặc tiếng Anh.',
    'draft',
    1
),
(
    3,
    'SEA Games 33 – Việt Nam giành 5 huy chương vàng ngày đầu',
    'sea-games-33-viet-nam-hcv-ngay-dau',
    'Ngày thi đấu đầu tiên của SEA Games 33 tại Thái Lan, đoàn thể thao Việt Nam đã xuất sắc giành được 5 huy chương vàng ở các nội dung bơi lội, cầu lông và cử tạ. Đây là khởi đầu ấn tượng, đặt nền móng cho mục tiêu top 3 toàn đoàn của Việt Nam tại kỳ đại hội này.',
    'published',
    1
);

-- ============================================================
--  GHI CHÚ MẬT KHẨU MẪU
-- ============================================================
--  Tài khoản admin:  username=admin  | password=Admin@123
--  Tài khoản sv01:   username=sv01   | password=123456
--  Tài khoản sv02:   username=sv02   | password=123456
--
--  Để tạo hash mới, chạy PHP:
--  echo password_hash('matkhau_cua_ban', PASSWORD_DEFAULT);
-- ============================================================
