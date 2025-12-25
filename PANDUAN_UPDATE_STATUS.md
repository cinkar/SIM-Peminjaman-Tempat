# Panduan Update Database - Status Reservasi

## Langkah-langkah Update Database

Untuk menambahkan fitur status pada sistem reservasi, ikuti langkah berikut:

### 1. Jalankan SQL Update
Buka **phpMyAdmin** atau tool database MySQL Anda, lalu:

1. Pilih database `spaceconnect`
2. Klik tab **SQL**
3. Copy dan paste query berikut:

```sql
-- Menambahkan kolom status ke tabel reservasi
ALTER TABLE `reservasi` ADD `status` VARCHAR(50) NOT NULL DEFAULT 'Disetujui' AFTER `catatanTambahan`;

-- Update data yang sudah ada agar memiliki status 'Disetujui'
UPDATE `reservasi` SET `status` = 'Disetujui' WHERE `status` = '';
```

4. Klik **Go** atau **Execute**

### 2. Verifikasi Perubahan
Setelah menjalankan query, cek tabel `reservasi`:
- Kolom baru `status` harus sudah ada
- Semua data existing harus memiliki status 'Disetujui'

## Cara Kerja Sistem

### Flow Reservasi:
1. **User mengajukan reservasi** → Data masuk ke tabel `pengajuanreservasi` dengan status implisit "Menunggu"
2. **Admin melihat di halaman Manajemen Reservasi** → Melihat semua pengajuan yang masuk
3. **Admin klik tombol "Setujui"** → 
   - Data dipindahkan dari `pengajuanreservasi` ke `reservasi`
   - Status otomatis di-set menjadi **'Disetujui'**
   - Data dihapus dari `pengajuanreservasi`
4. **User melihat di Profile** → 
   - Tab "Status Reservasi": Menampilkan pengajuan yang masih "Menunggu"
   - Tab "Riwayat Reservasi": Menampilkan reservasi yang sudah "Disetujui"

### Status Badge Colors:
- 🟡 **Menunggu** (bg-warning) - Kuning
- 🟢 **Disetujui** (bg-success) - Hijau
- 🔴 **Ditolak** (bg-danger) - Merah

## File yang Diubah

1. **update_reservasi_table.sql** (BARU)
   - File SQL untuk update struktur database

2. **adm-manajemen-reservasi.php**
   - Menambahkan field `status` dengan value 'Disetujui' saat insert ke tabel reservasi

3. **profile-user.php**
   - Menampilkan status dinamis dari database
   - Badge color berubah sesuai status

## Testing

Setelah update, test dengan:
1. Buat pengajuan reservasi baru sebagai user
2. Login sebagai admin
3. Setujui pengajuan tersebut
4. Login kembali sebagai user
5. Cek di tab "Riwayat Reservasi" - status harus "Disetujui" dengan badge hijau

## Troubleshooting

**Error: Unknown column 'status'**
- Pastikan sudah menjalankan SQL update di langkah 1

**Status masih "Menunggu"**
- Cek apakah data sudah ada di tabel `reservasi` (bukan `pengajuanreservasi`)
- Pastikan kolom `status` terisi dengan 'Disetujui'

**Badge tidak berwarna**
- Pastikan Bootstrap CSS sudah ter-load dengan benar
