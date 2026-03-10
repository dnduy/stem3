# PHP Lab Series – Hướng dẫn cài đặt

## Yêu cầu
- XAMPP / WAMP / Laragon (PHP 8.0+, MySQL 5.7+)
- Trình duyệt web

---

## Cài đặt nhanh (5 bước)

### Bước 1 – Copy thư mục vào htdocs
Sao chép toàn bộ thư mục `lab_login/` vào:
- XAMPP: `C:\xampp\htdocs\lab_login\`
- Laragon: `C:\laragon\www\lab_login\`

### Bước 2 – Import database
1. Mở phpMyAdmin: http://localhost/phpmyadmin
2. Chọn tab **Import**
3. Chọn file `database.sql`
4. Bấm **Go**

### Bước 3 – Kiểm tra kết nối
Mở file `db.php` và đổi thông tin nếu cần:
```php
$host = "localhost";
$user = "root";
$pass = "";          // ← đổi nếu MySQL của bạn có mật khẩu
$dbname = "lab_login";
```

### Bước 4 – Chạy ứng dụng

| Bài Lab | URL |
|---------|-----|
| Lab 01  | http://localhost/lab_login/lab01/login.php |
| Lab 02  | http://localhost/lab_login/lab02/login.php |
| Lab 03  | http://localhost/lab_login/lab03/news/index.php |

### Bước 5 – Tài khoản mẫu

| Username | Password  | Role  |
|----------|-----------|-------|
| admin    | Admin@123 | admin |
| sv01     | 123456    | user  |
| sv02     | 123456    | user  |

---

## Cấu trúc thư mục

```
lab_login/
│
├── db.php                  ← Kết nối CSDL (dùng chung)
├── database.sql            ← Import vào phpMyAdmin
│
├── lab01/                  ← Lab 01: Login cơ bản
│   ├── login.php
│   ├── process_login.php
│   ├── dashboard.php
│   └── logout.php
│
├── lab02/                  ← Lab 02: Bảo mật + CRUD User
│   ├── login.php
│   ├── process_login.php
│   ├── register.php
│   ├── process_register.php
│   ├── dashboard.php
│   ├── logout.php
│   └── admin/
│       ├── index.php       ← Danh sách user
│       ├── edit.php        ← Sửa user
│       └── delete.php      ← Xóa user
│
└── lab03/                  ← Lab 03: Quản lý tin tức
    ├── functions.php       ← Thư viện hàm dùng chung
    ├── news/               ← Trang công khai
    │   ├── index.php
    │   ├── category.php
    │   └── detail.php
    └── admin/
        ├── categories/     ← CRUD chuyên mục
        │   ├── index.php
        │   ├── create.php
        │   ├── edit.php
        │   └── delete.php
        └── posts/          ← CRUD bài viết
            ├── index.php
            ├── create.php
            ├── edit.php
            └── delete.php
```

---

## Lưu ý

- Lab 01 dùng plain-text password và SQL ghép chuỗi (mục đích: minh họa sai lầm cần tránh)
- Lab 02 nâng cấp lên `password_hash()` và Prepared Statement
- Lab 03 cần kế thừa `db.php` từ thư mục gốc và dùng `functions.php` riêng
- File `database.sql` đã bao gồm dữ liệu mẫu, **không cần chạy thêm SQL nào khác**
