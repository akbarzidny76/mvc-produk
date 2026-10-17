<?php

class Kategori
{
    public function __construct(private PDO $db) {}

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT k.id, k.nama_kategori, k.deskripsi,
                    (SELECT COUNT(*) FROM produk p WHERE p.kategori_id = k.id) AS jumlah_produk
             FROM kategori k
             ORDER BY k.nama_kategori'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id, nama_kategori, deskripsi FROM kategori WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insert(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO kategori (nama_kategori, deskripsi)
             VALUES (:nama_kategori, :deskripsi)'
        );
        return $stmt->execute([
            ':nama_kategori' => $data['nama_kategori'],
            ':deskripsi'     => $data['deskripsi'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE kategori
             SET nama_kategori = :nama_kategori, deskripsi = :deskripsi
             WHERE id = :id'
        );
        return $stmt->execute([
            ':id'            => $id,
            ':nama_kategori' => $data['nama_kategori'],
            ':deskripsi'     => $data['deskripsi'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM kategori WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}