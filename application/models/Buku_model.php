<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Buku_model extends CI_Model
{
    
    protected $table = 'buku';

    public function __construct()
    {
        parent::__construct();
    }

    
    public function get_all($kategori = null, $keyword = null, $limit = null, $offset = 0)
    {
        $this->_terapkan_filter($kategori, $keyword);

        $this->db->order_by('tanggal_upload', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get($this->table)->result();
    }

    
    public function count_all($kategori = null, $keyword = null)
    {
        $this->_terapkan_filter($kategori, $keyword);
        return $this->db->count_all_results($this->table);
    }

    
    private function _terapkan_filter($kategori = null, $keyword = null)
    {
        if (!empty($kategori)) {
            $this->db->where('kategori', $kategori);
        }

        if (!empty($keyword)) {
            // like() otomatis mencegah SQL Injection, aman dipakai
            $this->db->group_start();
            $this->db->like('judul', $keyword);
            $this->db->or_like('pengarang', $keyword);
            $this->db->group_end();
        }
    }

    
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    
    public function get_kategori_list()
    {
        return $this->db->distinct()
                         ->select('kategori')
                         ->get($this->table)
                         ->result();
    }

    
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    
    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}
