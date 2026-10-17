<?php

class ProdukController
{
    private const STATUS = ['aktif', 'nonaktif'];

    public function __construct(
        private Produk $model,
        private Kategori $kategoriModel
    ) {}

    public function index(): void
    {
        $produk = $this->model->getAll();
        $title  = 'Data Produk';
        require __DIR__ . '/../views/produk/index.php';
    }

    public function create(): void
    {
        $daftarKategori = $this->kategoriModel->getAll();
        $title          = 'Tambah Produk';
        require __DIR__ . '/../views/produk/create.php';
    }

    public function store(): void
    {
        $this->requirePost();
        [$data, $errors] = $this->validateInput($_POST);

        if ($errors) {
            $this->failBack($errors, 'create');
        }

        try {
            $this->model->insert($data);
            flash('success', 'Produk berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->handleDbError($e, 'create');
        }
        redirect('produk');
    }

    public function edit(): void
    {
        $id  = (int) ($_GET['id'] ?? 0);
        $row = $this->model->findById($id);

        if (!$row) {
            flash('error', 'Produk tidak ditemukan.');
            redirect('produk');
        }

        $daftarKategori = $this->kategoriModel->getAll();
        $title          = 'Edit Produk';
        require __DIR__ . '/../views/produk/edit.php';
    }

    public function update(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);

        if (!$this->model->findById($id)) {
            flash('error', 'Produk tidak ditemukan.');
            redirect('produk');
        }

        [$data, $errors] = $this->validateInput($_POST);
        if ($errors) {
            $this->failBack($errors, 'edit', ['id' => $id]);
        }

        try {
            $this->model->update($id, $data);
            flash('success', 'Produk berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->handleDbError($e, 'edit', ['id' => $id]);
        }
        redirect('produk');
    }

    public function delete(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->model->delete($id);
            flash('success', 'Produk berhasil dihapus.');
        } catch (PDOException $e) {
            flash('error', 'Produk gagal dihapus.');
        }
        redirect('produk');
    }

    private function validateInput(array $input): array
    {
        $data = [
            'kode_produk' => strtoupper(trim($input['kode_produk'] ?? '')),
            'nama_produk' => trim($input['nama_produk'] ?? ''),
            'kategori_id' => (int) ($input['kategori_id'] ?? 0),
            'harga'       => trim($input['harga'] ?? ''),
            'stok'        => trim($input['stok'] ?? ''),
            'deskripsi'   => trim($input['deskripsi'] ?? ''),
            'status'      => trim($input['status'] ?? 'aktif'),
        ];
        $errors = [];

        if ($data['kode_produk'] === '' || strlen($data['kode_produk']) > 20) {
            $errors[] = 'Kode produk wajib diisi (maksimal 20 karakter).';
        }
        if ($data['nama_produk'] === '' || strlen($data['nama_produk']) > 100) {
            $errors[] = 'Nama produk wajib diisi (maksimal 100 karakter).';
        }
        if (!$this->kategoriModel->findById($data['kategori_id'])) {
            $errors[] = 'Kategori yang dipilih tidak valid.';
        }
        if (!is_numeric($data['harga']) || (float) $data['harga'] <= 0) {
            $errors[] = 'Harga harus berupa angka lebih dari 0.';
        }
        if (filter_var($data['stok'], FILTER_VALIDATE_INT) === false || (int) $data['stok'] < 0) {
            $errors[] = 'Stok harus berupa bilangan bulat 0 atau lebih.';
        } else {
            $data['stok'] = (int) $data['stok'];
        }
        if (!in_array($data['status'], self::STATUS, true)) {
            $errors[] = 'Status produk tidak valid.';
        }
        if ($data['deskripsi'] === '') {
            $data['deskripsi'] = null;
        }

        return [$data, $errors];
    }

    private function failBack(array $errors, string $action, array $params = []): never
    {
        flash('error', implode(' ', $errors));
        $_SESSION['old'] = $_POST;
        redirect('produk', $action, $params);
    }

    private function handleDbError(PDOException $e, string $action, array $params = []): never
    {
        $message = $e->getCode() === '23000'
            ? 'Kode produk sudah digunakan.'
            : 'Terjadi kesalahan pada database.';
        flash('error', $message);
        $_SESSION['old'] = $_POST;
        redirect('produk', $action, $params);
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }
    }
}