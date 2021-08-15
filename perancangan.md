# APLIKASI SISTEM PEMESANAN/BOOKING SERVIS MOBIL

## PENGGUNA APLIKASI

### WEB

-   admin
-   karyawan

### MOBILE

-   pelanggan

## PERANCANGAN DATABASE

### admin

-   id_admin PK
-   nama_admin
-   username_admin
-   password_admin
-   nik_admin
-   nohp_admin
-   alamat_admin
-   foto_admin
-   level_admin [Pemilik, Karyawan]

### montir

-   id_montir PK
-   nama_montir
-   nik_montir
-   nohp_montir
-   alamat_montir
-   foto_montir

### pelanggan

-   id_pelanggan PK
-   nama_pelanggan
-   username_pelanggan
-   email_pelanggan
-   password_pelanggan
-   jk_pelanggan
-   nohp_pelanggan
-   alamat_pelanggan
-   foto_pelanggan

### kendaraan_pelanggan

-   id_kendaraan_pelanggan PK
-   id_pelanggan FK
-   nama_kendaraan
-   merek_kendaraan
-   tahun_kendaraan
-   nomor_polisi
-   nomor_rangka

### kategori

-   id_kategori PK
-   nama_kategori
-   deskripsi_kategori

### produk

-   id_produk PK
-   nama_produk
-   harga_produk
-   deskripsi_produk
-   gambar_produk
-   id_kategori FK

### layanan (paket)

-   id_layanan PK
-   nama_layanan
-   deskripsi_layanan

### produk_layanan (produk dari layanan)

-   id_produk_layanan PK
-   id_layanan FK
-   id_produk FK

### pemesanan

-   id_pemesanan PK
-   id_pelanggan FK
-   id_layanan FK
-   id_kendaraan FK
-   keluhan_kendaraan
-   tanggal_pemesanan
-   tanggal_servis_pemesanan <-- tanggal servis yang booking
-   tipe_pemesanan [Via Aplikasi, Langsung]

---

-   konfirmasi_kehadiran
-   pesan_konfirmasi_kehadiran

### servis

-   id_servis PK
-   id_pemesanan FK
-   tanggal_servis
-   tanggal_servis_lanjutan
-   status_servis [Proses, Selesai]
-   id_montir FK
-   catatan_servis
-   biaya_servis

## pembayaran

-   id_pembayaran PK
-   id_servis FK
-   total_pembayaran
-   kembalian_pembayaran
-   metode_pembayaran [Tunai, Kartu]
-   catatan_pembayaran

## pemberitahuan

-   id_pemberitahuan
-   id_pemesanan
-   id_admin
-   status [Dibaca, Belum Dibaca]
