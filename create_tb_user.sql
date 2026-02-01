-- Buat table tb_user dengan struktur lengkap
CREATE TABLE tb_user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'petugas', 'owner') NOT NULL DEFAULT 'petugas',
  status_aktif TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO tb_user (nama_lengkap, email, password, role, status_aktif) VALUES
('Admin User', 'admin@gmail.com', 'admin123', 'admin', 1),
('Petugas User', 'petugas@gmail.com', '1245678', 'petugas', 1),
('Owner User', 'owner@gmail.com', 'owner123', 'owner', 1);
