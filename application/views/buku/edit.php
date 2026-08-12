<a href="<?= base_url('buku') ?>" class="link-kembali">&larr; Kembali ke daftar buku</a>

<h1>Edit Buku</h1>

<?php
echo validation_errors('<div class="alert alert-error">', '</div>');

if (isset($error_upload)):
?>
    <div class="alert alert-error"><?= $error_upload ?></div>
<?php endif; ?>


<form action="<?= base_url('buku/edit/' . $buku->id) ?>" method="post" enctype="multipart/form-data" class="form-tambah">

    <label for="judul">Judul Buku</label>
    <input type="text" id="judul" name="judul"
           value="<?= set_value('judul', $buku->judul) ?>" required>

    <label for="pengarang">Pengarang</label>
    <input type="text" id="pengarang" name="pengarang"
           value="<?= set_value('pengarang', $buku->pengarang) ?>" required>

    <label for="kategori">Kategori</label>
    <input type="text" id="kategori" name="kategori" list="list-kategori"
           value="<?= set_value('kategori', $buku->kategori) ?>" required>
    <datalist id="list-kategori">
        <?php foreach ($daftar_kategori as $k): ?>
            <option value="<?= html_escape($k->kategori) ?>">
        <?php endforeach; ?>
    </datalist>

    <label for="kelas">Untuk Kelas</label>
    <select id="kelas" name="kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php $pilihan_kelas = array('Semua' => 'Semua Kelas', '1' => 'Kelas 1', '2' => 'Kelas 2', '3' => 'Kelas 3', '4' => 'Kelas 4', '5' => 'Kelas 5', '6' => 'Kelas 6'); ?>
        <?php foreach ($pilihan_kelas as $nilai => $label): ?>
            <option value="<?= $nilai ?>" <?= ($buku->kelas === $nilai) ? 'selected' : '' ?>>
                <?= $label ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="deskripsi">Deskripsi Singkat</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"><?= set_value('deskripsi', $buku->deskripsi) ?></textarea>

    <!-- Preview sampul yang sedang dipakai -->
    <label>Sampul Saat Ini</label>
    <img src="<?= base_url('assets/uploads/cover/' . $buku->sampul) ?>"
         alt="Sampul saat ini" class="preview-sampul">

    <label for="sampul">Ganti Sampul (opsional, JPG/PNG)</label>
    <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png">
    <small class="bantuan-teks">Kosongkan kalau tidak mau ganti sampul.</small>

    
    <label>File Buku Saat Ini</label>
    <p class="info-file-lama">
        📄 <?= html_escape($buku->file_buku) ?>
        (<a href="<?= base_url('assets/uploads/buku/' . $buku->file_buku) ?>" target="_blank">lihat</a>)
    </p>

    <label for="file_buku">Ganti File PDF (opsional)</label>
    <input type="file" id="file_buku" name="file_buku" accept="application/pdf">
    <small class="bantuan-teks">Kosongkan kalau tidak mau ganti file PDF-nya.</small>

    <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
</form>
