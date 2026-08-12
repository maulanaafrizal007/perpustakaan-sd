<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul_halaman) ? $judul_halaman : 'Perpustakaan Digital SD' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

    <header class="navbar">
        <a href="<?= base_url('buku') ?>" class="logo">📚 Perpustakaan Digital Sekolah Dasar</a>
        <nav>
            <a href="<?= base_url('buku') ?>">Beranda</a>
            <a href="<?= base_url('buku/tambah') ?>">+ Tambah Buku</a>
        </nav>
    </header>

    <main class="container">
        <?php
        
        $pesan_sukses = $this->session->flashdata('sukses');
        if ($pesan_sukses):
        ?>
            <div class="alert alert-sukses"><?= $pesan_sukses ?></div>
        <?php endif; ?>
