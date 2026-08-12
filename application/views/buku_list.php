<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f7ff;
            color: #333;
        }

        header {
            background-color: #2e86de;
            color: white;
            padding: 20px 30px;
            text-align: center;
        }

        header h1 {
            font-size: 26px;
        }

        header p {
            margin-top: 5px;
            font-size: 14px;
            opacity: 0.9;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .grid-buku {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .kartu-buku {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .kartu-buku:hover {
            transform: translateY(-5px);
        }

        .sampul-buku {
            width: 100%;
            height: 180px;
            background-color: #d6e9ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #2e86de;
        }

        .info-buku {
            padding: 15px;
        }

        .info-buku h3 {
            font-size: 16px;
            margin-bottom: 6px;
            color: #1a1a1a;
        }

        .info-buku p {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
        }

        .label-kategori {
            display: inline-block;
            background-color: #ffe8a3;
            color: #8a6100;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 20px;
            margin-top: 8px;
        }

        .kosong {
            text-align: center;
            color: #888;
            margin-top: 50px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <header>
        <h1>📚 Perpustakaan Digital Sekolah</h1>
        <p>Ayo membaca, temukan buku favoritmu!</p>
    </header>

    <div class="container">

        <?php if (empty($list_buku)): ?>

            <p class="kosong">Belum ada buku yang tersedia.</p>

        <?php else: ?>

            <div class="grid-buku">
                <?php foreach ($list_buku as $buku): ?>
                    <div class="kartu-buku">
                        <div class="sampul-buku">📖</div>
                        <div class="info-buku">
                            <h3><?= htmlspecialchars($buku->judul) ?></h3>
                            <p>Penulis: <?= htmlspecialchars($buku->pengarang) ?></p>
                            <p>Untuk: <?= htmlspecialchars($buku->kelas) ?></p>
                            <span class="label-kategori"><?= htmlspecialchars($buku->kategori) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>

</body>
</html>
