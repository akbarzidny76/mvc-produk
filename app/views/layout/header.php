<?php $flash = pullFlash(); $current = $_GET['page'] ?? 'produk'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Data Produk') ?> - Data Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        nav { background: #1f4e79; padding: 12px 24px; }
        nav a { color: #fff; text-decoration: none; margin-right: 20px; font-weight: bold; }
        nav a.active { border-bottom: 2px solid #fff; }
        main { max-width: 960px; margin: 24px auto; background: #fff; padding: 24px; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 14px; }
        th { background: #eef2f6; }
        .alert { padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .alert.success { background: #d4edda; color: #155724; }
        .alert.error { background: #f8d7da; color: #721c24; }
        .btn { display: inline-block; padding: 6px 12px; background: #1f4e79; color: #fff;
               border: 0; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn.danger { background: #c0392b; }
        .btn.secondary { background: #6c757d; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 12px; color: #fff; }
        .badge.aktif { background: #28a745; }
        .badge.nonaktif { background: #6c757d; }
        .stok-rendah { color: #c0392b; font-weight: bold; }
        .actions form { display: inline; }
    </style>
</head>
<body>
<nav>
    <a href="index.php?page=produk" class="<?= $current === 'produk' ? 'active' : '' ?>">Produk</a>
    <a href="index.php?page=kategori" class="<?= $current === 'kategori' ? 'active' : '' ?>">Kategori</a>
</nav>
<main>
<?php if ($flash): ?>
    <div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>