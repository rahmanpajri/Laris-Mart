## Cara Menjalankan

1. Clone Project Github
   ```
   https://github.com/rahmanpajri/Laris-Mart.git
   cd laris-mart
   ```
2. Letakkan pada folder xampp/htdocs (karena url api mengarah ke localhost)
3. Buka melalui Visual Studio Code/Text Editor lainnya
4. Lakukan update composer
   ```
   composer update
   ```
5. Lakukan run npm
   ```
    npm run dev
    ```
6. Konfigurasi file .env sesuai dengan pengaturan database
   ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laris_mart
    DB_USERNAME=root
    DB_PASSWORD=
   ```
7. Melakukan migrasi database
   ```
   php artisan migrate
   ```
8. Melakukan seeding data (optional)
   ```
   php artisan db:seed
   ```
9. Jalankan aplikasi dengan mengetikkan
   ```
   php artisan serve
   ```
---
## Hal yang perlu diperhatikan

- Pastikan API telah terpanggil dengan benar (jika belum, silahkan ubah pada $urlApi pada Controller yang ada)
- Pastikan konfigurasi database benar di `.env`
- Pastikan versi PHP telah sesuai
---
## API Endpoint
Untuk menjalankan API silahkan akses terlebih dahulu `http://127.0.0.1/Laris-Mart/public`, lalu tambahkan endpointnya. Berikut list endpoint yang tersedia.
- `GET /api/transactions`: Mendapatkan semua transaksi
- `POST /api/transactions`: Menambahkan transaksi baru
- `PUT /api/transactions/{id}`: Mengupdate transaksi berdasarkan ID
- `DELETE /api/transactions/{id}`: Menghapus transaksi berdasarkan ID
- `GET /api/transactions/show`: Mendapatkan list data transaksi terbanyak
  
- `GET /api/categories`: Mendapatkan semua jenis barang
- `POST /api/categories`: Menambahkan jenis barang baru
- `PUT /api/categories/{id}`: Mengupdate jenis barang berdasarkan ID
- `DELETE /api/categories/{id}`: Menghapus jenis barang berdasarkan ID

- `GET /api/items`: Mendapatkan semua barang
- `POST /api/items`: Menambahkan barang baru
- `PUT /api/items/{id}`: Mengupdate barang berdasarkan ID
- `DELETE /api/items/{id}`: Menghapus barang berdasarkan ID


