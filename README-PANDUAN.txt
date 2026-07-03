* Program ini dibuat menggunakan Framework Laravel
* Program ini dibuat dengan tujuan tes di Jasuindo Tiga Perkasa
* program ini dijalankan dengan environment XAMPP dan mariaDB

Cara penggunaan program : 
1. buka git bash di folder coupon-jip
2. buat MariaDB dengan nama coupon-jip (menyesuaikan dengan .env)
3. jalankan php artisan migrate:fresh
4. jalankan php artisan db:seed UserLocationSeeder
5. jalankan program menggunakan php artisan serve (atau localhost/coupon-jip/public bila menggunakan local XAMPP)
6. tombol Generate Coupon adalah tombol untuk truncate table Batch, Box, Coupon dan Production Logs dan juga menambahkan ulang datanya secara Shuffle
7. tombol Lihat Laporan Kupon akan menampilkan data sesuai dengan report yang dijelaskan pada petunjuk