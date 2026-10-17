<?php require __DIR__ . '/../layout/header.php'; ?>

<h2>Tambah Produk</h2>
<form method="post" action="index.php?page=produk&action=store">
    <label for="kode_produk">Kode Produk</label>
    <input type="text" id="kode_produk" name="kode_produk" maxlength="20"
           value="<?= e(old('kode_produk')) ?>" required>

    <label for="nama_produk">Nama Produk</label>
    <input type="text" id="nama_produk" name="nama_produk" maxlength="100"
           value="<?= e(old('nama_produk')) ?>" required>

    <label for="kategori_id">Kategori</label>
    <select id="kategori_id" name="kategori_id" required>
        <option value="">-- Pilih kategori --</option>
        <?php foreach ($daftarKategori as $k): ?>
            <option value="<?= (int) $k['id'] ?>"
                <?= (int) old('kategori_id', 0) === (int) $k['id'] ? 'selected' : '' ?>>
                <?= e($k['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" min="1" step="100"
           value="<?= e(old('harga')) ?>" required>

    <label for="stok">Stok</label>
    <input type="number" id="stok" name="stok" min="0" step="1"
           value="<?= e(old('stok', 0)) ?>" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"><?= e(old('deskripsi')) ?></textarea>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        <?php foreach (['aktif', 'nonaktif'] as $s): ?>
            <option value="<?= $s ?>" <?= old('status', 'aktif') === $s ? 'selected' : '' ?>><?= $s ?></option>
        <?php endforeach; ?>
    </select>

    <p>
        <button type="submit" class="btn">Simpan</button>
        <a class="btn secondary" href="index.php?page=produk">Kembali</a>
    </p>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>