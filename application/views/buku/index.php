<h1>Daftar Buku Bacaan</h1>


<form action="<?= base_url('buku') ?>" method="get" class="form-filter">
    <input type="text" name="cari" placeholder="Cari judul atau pengarang..."
           value="<?= isset($keyword) ? html_escape($keyword) : '' ?>">

    <select name="kategori">
        <option value="">Semua Kategori</option>
        <?php foreach ($daftar_kategori as $k): ?>
            <option value="<?= html_escape($k->kategori) ?>"
                <?= (isset($kategori_aktif) && $kategori_aktif === $k->kategori) ? 'selected' : '' ?>>
                <?= html_escape($k->kategori) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Cari</button>
</form>


<div class="grid-buku">
    <?php if (empty($daftar_buku)): ?>
        <p class="kosong">Belum ada buku yang ditemukan.</p>
    <?php else: ?>
        <?php foreach ($daftar_buku as $buku): ?>
            <div class="kartu-buku">
                <img src="<?= base_url('assets/uploads/cover/' . $buku->sampul) ?>"
                     alt="Sampul <?= html_escape($buku->judul) ?>"
                     onerror="this.src='<?= base_url('assets/img/default-cover.png') ?>'">

                <div class="kartu-isi">
                    <h3><?= html_escape($buku->judul) ?></h3>
                    <p class="pengarang"><?= html_escape($buku->pengarang) ?></p>
                    <span class="badge"><?= html_escape($buku->kategori) ?></span>
                    <span class="badge badge-kelas">Kelas <?= html_escape($buku->kelas) ?></span>

                    <div class="kartu-aksi">
                        <a href="<?= base_url('buku/baca/' . $buku->id) ?>" class="btn btn-baca">Baca</a>
                        <a href="<?= base_url('buku/edit/' . $buku->id) ?>" class="btn btn-edit">Edit</a>
                        <a href="<?= base_url('buku/hapus/' . $buku->id) ?>"
                           class="btn btn-hapus"
                           onclick="return confirm('Yakin mau hapus buku ini?')">Hapus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (!empty($pagination_links)): ?>
    <div class="pagination-wrapper">
        <?= $pagination_links ?>
    </div>
<?php endif; ?>
