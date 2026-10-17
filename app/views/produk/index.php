<?php require __DIR__ . '/../layout/header.php'; ?>

<h2>Daftar Produk</h2>
<a class="btn" href="index.php?page=produk&action=create">Tambah Produk</a>

<table>
    <tr>
        <th>Kode</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php if (!$produk): ?>
        <tr><td colspan="7">Belum ada data produk.</td></tr>
    <?php endif; ?>
    <?php foreach ($produk as $p): ?>
        <tr>
            <td><?= e($p['kode_produk']) ?></td>
            <td><?= e($p['nama_produk']) ?></td>
            <td><?= e($p['nama_kategori']) ?></td>
            <td><?= e(rupiah($p['harga'])) ?></td>
            <td class="<?= (int) $p['stok'] <= 5 ? 'stok-rendah' : '' ?>"><?= (int) $p['stok'] ?></td>
            <td><span class="badge <?= e($p['status']) ?>"><?= e($p['status']) ?></span></td>
            <td class="actions">
                <a class="btn secondary" href="index.php?page=produk&action=edit&id=<?= (int) $p['id'] ?>">Edit</a>
                <form method="post" action="index.php?page=produk&action=delete"
                      onsubmit="return confirm('Hapus produk ini?')">
                    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <button type="submit" class="btn danger">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p><small>Stok berwarna merah berarti stok tinggal 5 atau kurang.</small></p>

<?php require __DIR__ . '/../layout/footer.php'; ?>