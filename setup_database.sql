-- Buat semua table untuk database parkir

-- 1. Table User
CREATE TABLE tb_user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'petugas', 'owner') NOT NULL DEFAULT 'petugas',
  status_aktif TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table Area Parkir
CREATE TABLE tb_area_parkir (
  id_area INT AUTO_INCREMENT PRIMARY KEY,
  nama_area VARCHAR(100) NOT NULL,
  jenis ENUM('motor', 'mobil', 'truck') NOT NULL,
  kapasitas INT NOT NULL,
  terisi INT DEFAULT 0,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table Tarif
CREATE TABLE tb_tarif (
  id_tarif INT AUTO_INCREMENT PRIMARY KEY,
  jenis_kendaraan VARCHAR(50) NOT NULL,
  tarif_per_jam INT NOT NULL,
  tarif_per_hari INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table Kendaraan
CREATE TABLE tb_kendaraan (
  id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
  plat_nomor VARCHAR(20) NOT NULL UNIQUE,
  jenis_kendaraan VARCHAR(50) NOT NULL,
  warna VARCHAR(50),
  pemilik VARCHAR(100),
  id_user INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES tb_user(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table Transaksi Parkir (tb_parkir)
CREATE TABLE tb_parkir (
  id_parkir INT AUTO_INCREMENT PRIMARY KEY,
  id_kendaraan INT,
  id_area INT,
  id_tarif INT,
  waktu_masuk DATETIME NOT NULL,
  waktu_keluar DATETIME,
  durasi_jam INT,
  biaya_total INT,
  status VARCHAR(20) DEFAULT 'aktif',
  id_user INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_kendaraan) REFERENCES tb_kendaraan(id_kendaraan),
  FOREIGN KEY (id_area) REFERENCES tb_area_parkir(id_area),
  FOREIGN KEY (id_tarif) REFERENCES tb_tarif(id_tarif),
  FOREIGN KEY (id_user) REFERENCES tb_user(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table Log Aktivitas
CREATE TABLE tb_log_aktivitas (
  id_log INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  aktivitas TEXT NOT NULL,
  waktu_aktivitas TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES tb_user(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data

-- User
INSERT INTO tb_user (nama_lengkap, email, password, role, status_aktif) VALUES
('Admin User', 'admin@gmail.com', 'admin123', 'admin', 1),
('Petugas User', 'petugas@gmail.com', '1245678', 'petugas', 1),
('Owner User', 'owner@gmail.com', 'owner123', 'owner', 1);

-- Area Parkir
INSERT INTO tb_area_parkir (nama_area, jenis, kapasitas, terisi, status) VALUES
('Area A - Motor', 'motor', 50, 0, 1),
('Area B - Mobil', 'mobil', 30, 0, 1),
('Area C - Truck', 'truck', 10, 0, 1);

-- Tarif
INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam, tarif_per_hari) VALUES
('Motor', 5000, 20000),
('Mobil', 10000, 50000),
('Truck', 15000, 100000);
