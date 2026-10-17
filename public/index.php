<?php

session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/helpers/helpers.php';
require __DIR__ . '/../app/models/Kategori.php';
require __DIR__ . '/../app/models/Produk.php';
require __DIR__ . '/../app/controllers/KategoriController.php';
require __DIR__ . '/../app/controllers/ProdukController.php';

try {
    $db = (new Database())->connect();
} catch (PDOException $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Periksa config/database.php dan pastikan database toko sudah diimpor.');
}

$kategoriModel = new Kategori($db);
$produkModel   = new Produk($db);

$page   = $_GET['page'] ?? 'produk';
$action = $_GET['action'] ?? 'index';

$controller = match ($page) {
    'produk'   => new ProdukController($produkModel, $kategoriModel),
    'kategori' => new KategoriController($kategoriModel),
    default    => null,
};

if ($controller === null) {
    http_response_code(404);
    exit('Halaman tidak ditemukan.');
}

match ($action) {
    'index'  => $controller->index(),
    'create' => $controller->create(),
    'store'  => $controller->store(),
    'edit'   => $controller->edit(),
    'update' => $controller->update(),
    'delete' => $controller->delete(),
    default  => (function () {
        http_response_code(404);
        exit('Action tidak ditemukan.');
    })(),
};