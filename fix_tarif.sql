-- Check if column exists, if not add it
-- First check structure
DESC tb_tarif;

-- Add column if not exists (MySQL doesn't have IF NOT EXISTS for columns, so we'll try to add)
ALTER TABLE tb_tarif ADD COLUMN IF NOT EXISTS tarif_per_hari INT NOT NULL DEFAULT 0 AFTER tarif_per_jam;

-- Verify
SELECT * FROM tb_tarif LIMIT 1;
