# Latihan modul server side tk Provinsi

Facegram adalah sebuah aplikasi mirip seperti instagram dimana user dapat melihat postingan user lain dan user bisa registrasi sebagai akun private sehingga user lain yang tidak memfollownya tidak bisa melihat postingannya.

## Tech stack
- Laravel 10.x
- Vue 3.x 
- Vue router
- axios

## Fitur
### Backend
- [x] Authentikasi
    - [x] Login  
    - [x] Register   
    - [x] Logout   
- [x] Post
    - [x] Create new post
    - [x] Delete post
    - [x] Get posts
- [x] Following
    - [x] Follow a user
    - [x] Unfollow a user
    - [x] Get following user
    - [x] get user
- [x] Follower
    - [x] Accept follower
    - [x] Get follower user
- [x] User
    - [x] Get user
    - [x] Get detail user by username

## Frontend


## Catatan
Aplikasi ini terbagi menjadi 2, yaitu frontend dan backend, anda harus menjalankannya secara bersamaan lalu membuka url frontend untuk melihat tampilan website dengan backend untuk menjalankan logika bisnis aplikasi

## Installasi
### Bagian backend
1. pastikan anda memiliki php versi 8.x dan mysql database
2. buka folder BACKEND
3. buat .env file atau anda bisa mencopasnya dari .env.example lalu mengganti namanya menjadi .env
4. setting konfigurasi untuk database dan url frontend 
5. jalankan perintah berikut
```bash
# install dependency
composer install
# untuk menglink storage aplikasi
php artisan storage link
# migrasi database
php artisan migrate
```

### Bagian frontend
1. pastikan anda memiliki npm dan node js 
2. buka folder FRONTEND
3. buat file .env atau anda bisa mencopas dan mengganti nama dari file .env.example
4.  jalankan perintah berikut
```bash
# install dependency
npm install
# menjalankan aplikasi
npm run dev
```

## Cara menjalankan

## Hal yang saya pelajari
berikut artikel terkait yang saya tulis ketika saya membuat aplikasi ini [klik disini]() 