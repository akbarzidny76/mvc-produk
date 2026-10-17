<?php

class Produk
{
    public function __construct(private PDO $db) {}

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT p.id, p.kode_produk, p.nama_produk, p.harga, p.stok, p.status,
                    p.kategori_id, k.nama_kategori
             FROM produk p
             JOIN kategori k ON k.id = p.kategori_id
             ORDER BY p.nama_produk'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id, kode_produk, nama_produk, kategori_id, harga, stok, deskripsi, status
             FROM produk WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insert(array $data): bool
    {
        $sql = 'INSERT INTO produk (kode_produk, nama_produk, kategori_id, harga, stok, deskripsi, status)
                VALUES (:kode_produk, :nama_produk, :kategori_id, :harga, :stok, :deskripsi, :status)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':kode_produk' => $data['kode_produk'],
            ':nama_produk' => $data['nama_produk'],
            ':kategori_id' => $data['kategori_id'],
            ':harga'       => $data['harga'],
            ':stok'        => $data['stok'],
            ':deskripsi'   => $data['deskripsi'],
            ':status'      => $data['status'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE produk
                SET kode_produk = :kode_produk, nama_produk = :nama_produk,
                    kategori_id = :kategori_id, harga = :harga, stok = :stok,
                    deskripsi = :deskripsi, status = :status
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'          => $id,
            ':kode_produk' => $data['kode_produk'],
            ':nama_produk' => $data['nama_produk'],
            ':kategori_id' => $data['kategori_id'],
            ':harga'       => $data['harga'],
            ':stok'        => $data['stok'],
            ':deskripsi'   => $data['deskripsi'],
            ':status'      => $data['status'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM produk WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}