<a href="<?= base_url('buku') ?>" class="link-kembali">&larr; Kembali ke daftar buku</a>

<h1><?= html_escape($buku->judul) ?></h1>
<p class="pengarang">Oleh: <?= html_escape($buku->pengarang) ?></p>
<p><?= html_escape($buku->deskripsi) ?></p>


<div class="pdf-viewer">
    <embed
        src="<?= base_url('assets/uploads/buku/' . $buku->file_buku) ?>"
        type="application/pdf"
        width="100%"
        height="700px">
</div>

<p class="catatan">
    Kalau PDF tidak muncul, <a href="<?= base_url('assets/uploads/buku/' . $buku->file_buku) ?>" target="_blank">klik di sini untuk membuka di tab baru</a>.
</p>
