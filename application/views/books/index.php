<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital SD</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header class="header">
    <h1>📚 Perpustakaan Digital Sekolah</h1>
</header>

<div class="container">

    <!-- Form Pencarian & Filter -->
    <form method="get" action="<?= base_url('books') ?>" class="search-form">
        <input type="text" name="keyword" placeholder="Cari judul atau pengarang..."
               value="<?= htmlspecialchars($keyword) ?>">

        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k->kategori ?>"
                    <?= ($kategori_terpilih == $k->kategori) ? 'selected' : '' ?>>
                    <?= $k->kategori ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Cari</button>
    </form>

    <!-- Daftar Buku -->
    <div class="book-grid">
        <?php if (count($buku) > 0): ?>
            <?php foreach ($buku as $b): ?>
                <a href="<?= base_url('books/detail/' . $b->id) ?>" class="book-card">
                    <img src="<?= base_url('assets/img/sampul/' . $b->sampul) ?>"
                         alt="<?= $b->judul ?>"
                         onerror="this.src='<?= base_url('assets/img/sampul/default.jpg') ?>'">
                    <div class="book-info">
                        <h3><?= $b->judul ?></h3>
                        <p class="pengarang"><?= $b->pengarang ?></p>
                        <span class="badge"><?= $b->kategori ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">Buku tidak ditemukan. Coba kata kunci lain ya!</p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
