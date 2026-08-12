<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('buku_model');
    }

    
    public function index()
    {
        $kategori = $this->input->get('kategori');
        $keyword  = $this->input->get('cari');

        
        $per_halaman = 3;

        $halaman_aktif = (int) $this->input->get('halaman');
        if ($halaman_aktif < 1) {
            $halaman_aktif = 1;
        }
        $offset = ($halaman_aktif - 1) * $per_halaman;

        $total_buku = $this->buku_model->count_all($kategori, $keyword);

        
        $query_params = array();
        if (!empty($kategori)) {
            $query_params['kategori'] = $kategori;
        }
        if (!empty($keyword)) {
            $query_params['cari'] = $keyword;
        }
        $query_string = !empty($query_params) ? '?' . http_build_query($query_params) : '';

        $this->load->library('pagination');

        $config['base_url'] = base_url('buku' . $query_string);
        $config['total_rows'] = $total_buku;
        $config['per_page'] = $per_halaman;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'halaman';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;

        
        $config['full_tag_open'] = '<nav class="pagination">';
        $config['full_tag_close'] = '</nav>';
        $config['attributes'] = array('class' => 'page-link');
        $config['cur_tag_open'] = '<span class="page-aktif">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '&laquo; Sebelumnya';
        $config['next_link'] = 'Selanjutnya &raquo;';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';

        $this->pagination->initialize($config);

        $data['daftar_buku'] = $this->buku_model->get_all($kategori, $keyword, $per_halaman, $offset);
        $data['daftar_kategori'] = $this->buku_model->get_kategori_list();
        $data['kategori_aktif'] = $kategori;
        $data['keyword'] = $keyword;
        $data['pagination_links'] = $this->pagination->create_links();
        $data['total_buku'] = $total_buku;

        $this->load->view('templates/header', array('judul_halaman' => 'Perpustakaan Digital SD'));
        $this->load->view('buku/index', $data);
        $this->load->view('templates/footer');
    }

    
    public function baca($id)
    {
        $buku = $this->buku_model->get_by_id($id);

        if (!$buku) {
            show_404();
            return;
        }

        $data['buku'] = $buku;

        $this->load->view('templates/header', array('judul_halaman' => $buku->judul));
        $this->load->view('buku/baca', $data);
        $this->load->view('templates/footer');
    }

    
    public function tambah()
    {
        
        if ($this->input->method() === 'post') {
            $this->_simpan_buku();
            return;
        }

        $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

        $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
        $this->load->view('buku/tambah', $data);
        $this->load->view('templates/footer');
    }

    
    public function edit($id)
    {
        $buku = $this->buku_model->get_by_id($id);

        if (!$buku) {
            show_404();
            return;
        }

        
        if ($this->input->method() === 'post') {
            $this->_update_buku($id, $buku);
            return;
        }

        $data['buku'] = $buku;
        $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

        $this->load->view('templates/header', array('judul_halaman' => 'Edit Buku'));
        $this->load->view('buku/edit', $data);
        $this->load->view('templates/footer');
    }

    
    private function _update_buku($id, $buku_lama)
    {
        
        $this->form_validation->set_rules('judul', 'Judul Buku', 'required|trim');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'required|trim');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['buku'] = $buku_lama;
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

            $this->load->view('templates/header', array('judul_halaman' => 'Edit Buku'));
            $this->load->view('buku/edit', $data);
            $this->load->view('templates/footer');
            return;
        }

        
        $nama_sampul = $buku_lama->sampul;
        $nama_file_buku = $buku_lama->file_buku;

        
        if (!empty($_FILES['sampul']['name']) && $_FILES['sampul']['error'] === UPLOAD_ERR_OK) {
            $ekstensi_sampul = strtolower(pathinfo($_FILES['sampul']['name'], PATHINFO_EXTENSION));
            $ekstensi_diizinkan_sampul = array('jpg', 'jpeg', 'png');

            if (in_array($ekstensi_sampul, $ekstensi_diizinkan_sampul, TRUE)) {
                $sampul_baru = 'cover_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ekstensi_sampul;
                $tujuan_sampul = FCPATH . 'assets/uploads/cover/' . $sampul_baru;

                if (move_uploaded_file($_FILES['sampul']['tmp_name'], $tujuan_sampul)) {
                    
                    if ($nama_sampul !== 'default-cover.png') {
                        @unlink(FCPATH . 'assets/uploads/cover/' . $nama_sampul);
                    }
                    $nama_sampul = $sampul_baru;
                }
            }
        }

        
        if (!empty($_FILES['file_buku']['name']) && $_FILES['file_buku']['error'] === UPLOAD_ERR_OK) {
            $ekstensi_buku = strtolower(pathinfo($_FILES['file_buku']['name'], PATHINFO_EXTENSION));

            if ($ekstensi_buku !== 'pdf') {
                $data['error_upload'] = 'File buku harus berformat PDF. File yang kamu pilih: .' . $ekstensi_buku;
                $data['buku'] = $buku_lama;
                $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

                $this->load->view('templates/header', array('judul_halaman' => 'Edit Buku'));
                $this->load->view('buku/edit', $data);
                $this->load->view('templates/footer');
                return;
            }

            if ($_FILES['file_buku']['size'] > 20 * 1024 * 1024) {
                $data['error_upload'] = 'Ukuran file PDF maksimal 20 MB.';
                $data['buku'] = $buku_lama;
                $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

                $this->load->view('templates/header', array('judul_halaman' => 'Edit Buku'));
                $this->load->view('buku/edit', $data);
                $this->load->view('templates/footer');
                return;
            }

            $file_baru = 'buku_' . time() . '_' . mt_rand(1000, 9999) . '.pdf';
            $tujuan_buku = FCPATH . 'assets/uploads/buku/' . $file_baru;

            if (move_uploaded_file($_FILES['file_buku']['tmp_name'], $tujuan_buku)) {
                // Hapus file PDF lama dari server
                @unlink(FCPATH . 'assets/uploads/buku/' . $nama_file_buku);
                $nama_file_buku = $file_baru;
            }
        }

        
        $data_buku = array(
            'judul'      => $this->input->post('judul'),
            'pengarang'  => $this->input->post('pengarang'),
            'kategori'   => $this->input->post('kategori'),
            'kelas'      => $this->input->post('kelas'),
            'sampul'     => $nama_sampul,
            'file_buku'  => $nama_file_buku,
            'deskripsi'  => $this->input->post('deskripsi'),
        );

        $this->buku_model->update($id, $data_buku);

        $this->session->set_flashdata('sukses', 'Buku "' . $data_buku['judul'] . '" berhasil diperbarui!');
        redirect('buku');
    }

    
    private function _simpan_buku()
    {
        // Validasi input sederhana
        $this->form_validation->set_rules('judul', 'Judul Buku', 'required|trim');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'required|trim');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();
            $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
            $this->load->view('buku/tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        
        $nama_sampul = 'default-cover.png';

        if (!empty($_FILES['sampul']['name']) && $_FILES['sampul']['error'] === UPLOAD_ERR_OK) {
            $ekstensi_sampul = strtolower(pathinfo($_FILES['sampul']['name'], PATHINFO_EXTENSION));
            $ekstensi_diizinkan_sampul = array('jpg', 'jpeg', 'png');

            if (in_array($ekstensi_sampul, $ekstensi_diizinkan_sampul, TRUE)) {
                $nama_sampul = 'cover_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ekstensi_sampul;
                $tujuan_sampul = FCPATH . 'assets/uploads/cover/' . $nama_sampul;

                if (!move_uploaded_file($_FILES['sampul']['tmp_name'], $tujuan_sampul)) {
                    // Kalau gagal pindah file, tetap lanjut pakai cover default
                    $nama_sampul = 'default-cover.png';
                }
            }
            
        }

        
        if (empty($_FILES['file_buku']['name'])) {
            $data['error_upload'] = 'Silakan pilih file PDF buku terlebih dahulu.';
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

            $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
            $this->load->view('buku/tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $ekstensi_buku = strtolower(pathinfo($_FILES['file_buku']['name'], PATHINFO_EXTENSION));

        if ($ekstensi_buku !== 'pdf') {
            $data['error_upload'] = 'File buku harus berformat PDF. File yang kamu pilih: .' . $ekstensi_buku;
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

            $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
            $this->load->view('buku/tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        
        if ($_FILES['file_buku']['size'] > 20 * 1024 * 1024) {
            $data['error_upload'] = 'Ukuran file PDF maksimal 20 MB.';
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

            $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
            $this->load->view('buku/tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        $nama_file_buku = 'buku_' . time() . '_' . mt_rand(1000, 9999) . '.pdf';
        $tujuan_buku = FCPATH . 'assets/uploads/buku/' . $nama_file_buku;

        if (!move_uploaded_file($_FILES['file_buku']['tmp_name'], $tujuan_buku)) {
            $data['error_upload'] = 'Gagal menyimpan file PDF ke server. Cek folder assets/uploads/buku/ sudah ada dan bisa ditulisi.';
            $data['daftar_kategori'] = $this->buku_model->get_kategori_list();

            $this->load->view('templates/header', array('judul_halaman' => 'Tambah Buku Baru'));
            $this->load->view('buku/tambah', $data);
            $this->load->view('templates/footer');
            return;
        }

        
        $data_buku = array(
            'judul'      => $this->input->post('judul'),
            'pengarang'  => $this->input->post('pengarang'),
            'kategori'   => $this->input->post('kategori'),
            'kelas'      => $this->input->post('kelas'),
            'sampul'     => $nama_sampul,
            'file_buku'  => $nama_file_buku,
            'deskripsi'  => $this->input->post('deskripsi'),
        );

        $this->buku_model->insert($data_buku);

        $this->session->set_flashdata('sukses', 'Buku "' . $data_buku['judul'] . '" berhasil ditambahkan!');
        redirect('buku');
    }

    
    public function hapus($id)
    {
        $buku = $this->buku_model->get_by_id($id);

        if ($buku) {
            $this->buku_model->delete($id);
            $this->session->set_flashdata('sukses', 'Buku "' . $buku->judul . '" berhasil dihapus.');
        }

        redirect('buku');
    }
}
