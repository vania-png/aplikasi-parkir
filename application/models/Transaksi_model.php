<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function insert($data)
    {
        $this->db->insert('tb_parkir', $data);
        return $this->db->insert_id();
    }

    public function get_area()
    {
        return $this->db->get('tb_area_parkir')->result();
    }

    public function get_tarif()
    {
        return $this->db->get('tb_tarif')->result();
    }

    public function get_tarif_by_jenis($jenis)
    {
        return $this->db->get_where('tb_tarif', [
            'jenis_kendaraan' => $jenis
        ])->row();
    }

    public function get_by_id($id)
    {
        $this->db->select('tb_parkir.*, tb_area_parkir.nama_area');
        $this->db->from('tb_parkir');
        $this->db->join(
            'tb_area_parkir',
            'tb_area_parkir.id_area = tb_parkir.id_area',
            'left'
        );
        $this->db->where('tb_parkir.id_parkir', $id);

        return $this->db->get()->row();
    }

    public function get_total_kendaraan()
    {
        $this->db->where('waktu_keluar IS NULL');
        return $this->db->count_all_results('tb_parkir');
    }

    public function get_total_transaksi_hari_ini()
    {
        $this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
        return $this->db->count_all_results('tb_parkir');
    }

    public function get_total_pendapatan_hari_ini()
    {
        $this->db->select_sum('biaya_total');
        $this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
        $result = $this->db->get('tb_parkir')->row();
        return $result->biaya_total ?? 0;
    }

    public function get_total_area()
    {
        return $this->db->count_all('tb_area_parkir');
    }

    public function get_transaksi_terakhir($limit = 5)
    {
        $this->db->select('tb_parkir.*, tb_area_parkir.nama_area, tb_tarif.jenis_kendaraan, tb_kendaraan.plat_nomor as no_polisi');
        $this->db->from('tb_parkir');
        $this->db->join('tb_area_parkir', 'tb_area_parkir.id_area = tb_parkir.id_area', 'left');
        $this->db->join('tb_tarif', 'tb_tarif.id_tarif = tb_parkir.id_tarif', 'left');
        $this->db->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_parkir.id_kendaraan', 'left');
        $this->db->order_by('waktu_masuk', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_total_data_kendaraan()
    {
        return $this->db->count_all('tb_kendaraan');
    }

    public function get_transaksi_aktif()
    {
        $this->db->select('tb_parkir.*, tb_area_parkir.nama_area, tb_tarif.jenis_kendaraan');
        $this->db->from('tb_parkir');
        $this->db->join('tb_area_parkir', 'tb_area_parkir.id_area = tb_parkir.id_area', 'left');
        $this->db->join('tb_tarif', 'tb_tarif.id_tarif = tb_parkir.id_tarif', 'left');
        $this->db->where('tb_parkir.waktu_keluar IS NULL');
        $this->db->order_by('waktu_masuk', 'DESC');
        return $this->db->get()->result();
    }

    public function get_transaksi_hari_ini()
    {
        $this->db->select('tb_parkir.*, tb_area_parkir.nama_area, tb_tarif.jenis_kendaraan, tb_kendaraan.plat_nomor');
        $this->db->from('tb_parkir');
        $this->db->join('tb_area_parkir', 'tb_area_parkir.id_area = tb_parkir.id_area', 'left');
        $this->db->join('tb_tarif', 'tb_tarif.id_tarif = tb_parkir.id_tarif', 'left');
        $this->db->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_parkir.id_kendaraan', 'left');
        $this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
        $this->db->order_by('waktu_masuk', 'DESC');
        return $this->db->get()->result();
    }
}

