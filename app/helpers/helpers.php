<?php

/** Escape output untuk mencegah XSS. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Redirect ke halaman tertentu pada router. */
function redirect(string $page, string $action = '', array $params = []): never
{
    $query = ['page' => $page];
    if ($action !== '') {
        $query['action'] = $action;
    }
    header('Location: index.php?' . http_build_query($query + $params));
    exit;
}

/** Simpan pesan sukses/gagal untuk ditampilkan setelah redirect. */
function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function pullFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/** Input lama form (dipakai saat validasi gagal). */
function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['old'][$key] ?? $default;
}

function clearOld(): void
{
    unset($_SESSION['old']);
}

function rupiah(float|int|string $angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}