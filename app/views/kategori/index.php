<?php require __DIR__ . '/../layout/header.php'; ?>

<h2>Daftar Kategori</h2>
<a class="btn" href="index.php?page=kategori&action=create">Tambah Kategori</a>

<table>
    <tr>
        <th>Nama Kategori</th>
        <th>Deskripsi</th>
        <th>Jumlah Produk</th>
        <th>Aksi</th>
    </tr>
    <?php if (!$kategori): ?>
        <tr><td colspan="4">Belum ada data kategori.</td></tr>
    <?php endif; ?>
    <?php foreach ($kategori as $k): ?>
        <tr>
            <td><?= e($k['nama_kategori']) ?></td>
            <td><?= e($k['deskripsi'] ?? '-') ?></td>
            <td><?= (int) $k['jumlah_produk'] ?></td>
            <td class="actions">
                <a class="btn secondary" href="index.php?page=kategori&action=edit&id=<?= (int) $k['id'] ?>">Edit</a>
                <form method="post" action="index.php?page=kategori&action=delete"
                      onsubmit="return confirm('Hapus kategori ini?')">
                    <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
                    <button type="submit" class="btn danger">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>