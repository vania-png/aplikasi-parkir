USE parkir;

-- Drop column jika sudah ada yang salah
ALTER TABLE tb_tarif DROP COLUMN IF EXISTS tarif_per_hari;

-- Buat ulang column dengan benar
ALTER TABLE tb_tarif ADD COLUMN tarif_per_hari INT NOT NULL DEFAULT 0 AFTER tarif_per_jam;

-- Verify
DESCRIBE tb_tarif;
SELECT COUNT(*) as jml_kolom FROM information_schema.COLUMNS WHERE TABLE_NAME='tb_tarif' AND TABLE_SCHEMA='parkir';
