<?php require __DIR__ . '/../layout/header.php'; ?>

<h2>Tambah Kategori</h2>
<form method="post" action="index.php?page=kategori&action=store">
    <label for="nama_kategori">Nama Kategori</label>
    <input type="text" id="nama_kategori" name="nama_kategori" maxlength="50"
           value="<?= e(old('nama_kategori')) ?>" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="255"><?= e(old('deskripsi')) ?></textarea>

    <p>
        <button type="submit" class="btn">Simpan</button>
        <a class="btn secondary" href="index.php?page=kategori">Kembali</a>
    </p>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>