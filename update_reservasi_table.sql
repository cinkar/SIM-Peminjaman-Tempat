-- Menambahkan kolom status ke tabel reservasi
ALTER TABLE `reservasi` ADD `status` VARCHAR(50) NOT NULL DEFAULT 'Disetujui' AFTER `catatanTambahan`;

-- Update data yang sudah ada agar memiliki status 'Disetujui'
UPDATE `reservasi` SET `status` = 'Disetujui' WHERE `status` = '';
