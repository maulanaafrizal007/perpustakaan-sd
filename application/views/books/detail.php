<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $buku->judul ?> - Perpustakaan Digital SD</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header class="header">
    <h1>📚 Perpustakaan Digital Sekolah</h1>
</header>

<div class="container">

    <a href="<?= base_url('books') ?>" class="back-link">&larr; Kembali ke daftar buku</a>

    <div class="detail-wrapper">
        <div class="detail-cover">
            <img src="<?= base_url('assets/img/sampul/' . $buku->sampul) ?>"
                 alt="<?= $buku->judul ?>"
                 onerror="this.src='<?= base_url('assets/img/sampul/default.jpg') ?>'">
        </div>

        <div class="detail-info">
            <h2><?= $buku->judul ?></h2>
            <p><strong>Pengarang:</strong> <?= $buku->pengarang ?></p>
            <p><strong>Kategori:</strong> <?= $buku->kategori ?></p>
            <p><strong>Untuk:</strong> <?= $buku->kelas ?></p>
            <p class="sinopsis"><?= $buku->sinopsis ?></p>

            <a href="<?= base_url('assets/pdf/' . $buku->file_pdf) ?>"
               target="_blank" class="btn-baca">📖 Baca Buku Ini</a>
        </div>
    </div>

    
    <div class="pdf-viewer">
        <iframe src="<?= base_url('assets/pdf/' . $buku->file_pdf) ?>"
                width="100%" height="600px" style="border:1px solid #ccc; border-radius:8px;">
        </iframe>
    </div>

</div>

</body>
</html>
