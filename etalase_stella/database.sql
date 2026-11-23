-- Etalase Digital Stella (gabungan)
CREATE DATABASE IF NOT EXISTS database_etalase_stella_lkpd
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE database_etalase_stella_lkpd;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'siswa') DEFAULT 'siswa'
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_project VARCHAR(150) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    link_project VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Akun default dengan password baru yang sudah ter-hash:
-- 1. superadmin@stella.sch.id -> superadmin123
-- 2. admin@stella.sch.id      -> admin123
-- 3. siswa@stella.sch.id      -> siswa123
INSERT IGNORE INTO users (nama, email, password, role) VALUES
('Super Admin Stella', 'superadmin@stella.sch.id', '$2y$10$SojfC0K88YgyosFkqWHqTHumFct.4AzTh8ad8ct55bm089CEGSRYli', 'super_admin'),
('Admin Stella',       'admin@stella.sch.id',      '$2y$10$Icjtc06Dbj56BMDxpgJ43u1iJbBUcBT/9goNTdbCopRbfyN5SoD7y', 'admin'),
('Siswa Contoh',       'siswa@stella.sch.id',      '$2y$10$ApwPpwo7q/GODPbTRj1fy.8y1OulIp9zYSB3idM0Nx1TtQYJpSGae', 'siswa');