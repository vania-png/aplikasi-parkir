<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model
{
    private $table = 'tb_area_parkir';

    // Ambil semua data dengan perhitungan terisi otomatis
    public function getAll()
    {
        $areas = $this->db->get($this->table)->result();
        
        // Hitung terisi untuk setiap area berdasarkan transaksi aktif
        foreach ($areas as $area) {
            $terisi = $this->hitung_terisi($area->id_area);
            $area->terisi = $terisi;
            $area->sisa = $area->kapasitas - $terisi;
        }
        
        return $areas;
    }

    // Ambil data berdasarkan ID dengan perhitungan terisi otomatis
    public function getById($id)
    {
        $area = $this->db->get_where($this->table, ['id_area' => $id])->row();
        
        if ($area) {
            $terisi = $this->hitung_terisi($area->id_area);
            $area->terisi = $terisi;
            $area->sisa = $area->kapasitas - $terisi;
        }
        
        return $area;
    }

    // Hitung jumlah kendaraan yang sedang parkir (belum keluar) di area tertentu
    public function hitung_terisi($id_area)
    {
        $this->db->from('tb_parkir');
        $this->db->where('id_area', $id_area);
        $this->db->where('waktu_keluar IS NULL', null, false);
        return $this->db->count_all_results();
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
        $areas = $this->getAll();
        $total = 0;
        foreach ($areas as $area) {
            $total += $area->sisa;
        }
        return $total;
    }
}

