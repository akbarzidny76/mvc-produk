<?php

class KategoriController
{
    public function __construct(private Kategori $model) {}

    public function index(): void
    {
        $kategori = $this->model->getAll();
        $title    = 'Data Kategori';
        require __DIR__ . '/../views/kategori/index.php';
    }

    public function create(): void
    {
        $title = 'Tambah Kategori';
        require __DIR__ . '/../views/kategori/create.php';
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
            flash('success', 'Kategori berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->handleDbError($e, 'create');
        }
        redirect('kategori');
    }

    public function edit(): void
    {
        $id  = (int) ($_GET['id'] ?? 0);
        $row = $this->model->findById($id);

        if (!$row) {
            flash('error', 'Kategori tidak ditemukan.');
            redirect('kategori');
        }

        $title = 'Edit Kategori';
        require __DIR__ . '/../views/kategori/edit.php';
    }

    public function update(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);

        if (!$this->model->findById($id)) {
            flash('error', 'Kategori tidak ditemukan.');
            redirect('kategori');
        }

        [$data, $errors] = $this->validateInput($_POST);
        if ($errors) {
            $this->failBack($errors, 'edit', ['id' => $id]);
        }

        try {
            $this->model->update($id, $data);
            flash('success', 'Kategori berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->handleDbError($e, 'edit', ['id' => $id]);
        }
        redirect('kategori');
    }

    public function delete(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->model->delete($id);
            flash('success', 'Kategori berhasil dihapus.');
        } catch (PDOException $e) {
            flash('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }
        redirect('kategori');
    }

    private function validateInput(array $input): array
    {
        $data = [
            'nama_kategori' => trim($input['nama_kategori'] ?? ''),
            'deskripsi'     => trim($input['deskripsi'] ?? ''),
        ];
        $errors = [];

        if ($data['nama_kategori'] === '' || strlen($data['nama_kategori']) > 50) {
            $errors[] = 'Nama kategori wajib diisi (maksimal 50 karakter).';
        }
        if (strlen($data['deskripsi']) > 255) {
            $errors[] = 'Deskripsi maksimal 255 karakter.';
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
        redirect('kategori', $action, $params);
    }

    private function handleDbError(PDOException $e, string $action, array $params = []): never
    {
        $message = $e->getCode() === '23000'
            ? 'Nama kategori sudah digunakan.'
            : 'Terjadi kesalahan pada database.';
        flash('error', $message);
        $_SESSION['old'] = $_POST;
        redirect('kategori', $action, $params);
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode request tidak diizinkan.');
        }
    }
}