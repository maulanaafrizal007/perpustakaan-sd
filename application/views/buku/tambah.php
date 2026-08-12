<a href="<?= base_url('buku') ?>" class="link-kembali">&larr; Kembali ke daftar buku</a>

<h1>Tambah Buku Baru</h1>

<?php

echo validation_errors('<div class="alert alert-error">', '</div>');


if (isset($error_upload)):
?>
    <div class="alert alert-error"><?= $error_upload ?></div>
<?php endif; ?>


<form action="<?= base_url('buku/tambah') ?>" method="post" enctype="multipart/form-data" class="form-tambah">

    <label for="judul">Judul Buku</label>
    <input type="text" id="judul" name="judul" value="<?= set_value('judul') ?>" required>

    <label for="pengarang">Pengarang</label>
    <input type="text" id="pengarang" name="pengarang" value="<?= set_value('pengarang') ?>" required>

    <label for="kategori">Kategori</label>
    <input type="text" id="kategori" name="kategori" list="list-kategori"
           value="<?= set_value('kategori') ?>" placeholder="contoh: Dongeng, Sains, Sejarah" required>
    <datalist id="list-kategori">
        <?php foreach ($daftar_kategori as $k): ?>
            <option value="<?= html_escape($k->kategori) ?>">
        <?php endforeach; ?>
    </datalist>

    <label for="kelas">Untuk Kelas</label>
    <select id="kelas" name="kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <option value="Semua">Semua Kelas</option>
        <option value="1">Kelas 1</option>
        <option value="2">Kelas 2</option>
        <option value="3">Kelas 3</option>
        <option value="4">Kelas 4</option>
        <option value="5">Kelas 5</option>
        <option value="6">Kelas 6</option>
    </select>

    <label for="deskripsi">Deskripsi Singkat</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"><?= set_value('deskripsi') ?></textarea>

    <label for="sampul">Gambar Sampul (opsional, JPG/PNG)</label>
    <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png">

    <label for="file_buku">File Buku (wajib, PDF)</label>
    <input type="file" id="file_buku" name="file_buku" accept="application/pdf" required>

    <button type="submit" class="btn btn-simpan">Simpan Buku</button>
</form>
