<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model
{
    private $table = 'tb_area_parkir';

    // Ambil semua data
    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    // Ambil data berdasarkan ID
    public function getById($id)
    {
        return $this->db->get_where($this->table, ['id_area' => $id])->row();
    }

    // Insert data
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update data
    public function update($id, $data)
    {
        $this->db->where('id_area', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete data
    public function delete($id)
    {
        $this->db->where('id_area', $id);
        return $this->db->delete($this->table);
    }

    // Hitung total slot tersedia
    public function get_total_slot_tersedia()
    {
        $this->db->select('SUM(kapasitas - terisi) as total_slot');
        $result = $this->db->get($this->table)->row();
        return $result->total_slot ?? 0;
    }
}

