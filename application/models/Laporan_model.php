<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function hari_ini()
    {
        return $this->db->select('SUM(biaya_total) as total, COUNT(*) as transaksi')
                ->where('DATE(waktu_masuk)', date('Y-m-d'))
                ->get('tb_parkir')
                ->row();
    }

    public function transaksi_hari_ini()
    {
        // Ambil data transaksi hari ini dari Transaksi_model (sudah join area, tarif, kendaraan)
        $CI =& get_instance();
        $CI->load->model('Transaksi_model');
        $result = $CI->Transaksi_model->get_transaksi_hari_ini();
        // Filter hanya yang sudah keluar (waktu_keluar tidak null)
        $data = [];
        foreach ($result as $row) {
            if (!empty($row->waktu_keluar)) {
                $data[] = [
                    'no_polisi' => $row->plat_nomor,
                    'jenis_kendaraan' => $row->jenis_kendaraan,
                    'waktu_masuk' => $row->waktu_masuk,
                    'waktu_keluar' => $row->waktu_keluar,
                    'biaya_total' => $row->biaya_total,
                    // Tambahkan field lain jika perlu
                ];
            }
        }
        return $data;
    }

    public function mingguan()
    {
        return $this->db->select('SUM(biaya_total) as total, COUNT(*) as transaksi')
                ->where('waktu_masuk >=', date('Y-m-d', strtotime('-7 days')))
                ->get('tb_parkir')
                ->row();
    }

    public function bulanan()
    {
        return $this->db->select('SUM(biaya_total) as total')
                ->where('MONTH(waktu_masuk)', date('m'))
                ->where('YEAR(waktu_masuk)', date('Y'))
                ->get('tb_parkir')
                ->row();
    }

    // Ambil laporan kustom berdasarkan periode
    public function get_laporan_custom($mulai, $sampai)
    {
        // Filter transaksi yang benar-benar sudah keluar (waktu_keluar IS NOT NULL)
        $this->db->where('waktu_keluar IS NOT NULL');
        $this->db->where('DATE(waktu_keluar) >=', $mulai);
        $this->db->where('DATE(waktu_keluar) <=', $sampai);

        $query = $this->db->select('SUM(biaya_total) as total_pendapatan, COUNT(*) as jumlah_keluar')
            ->get('tb_parkir');
        $summary = $query->row_array();

        // Ambil detail transaksi keluar
        $this->db->where('waktu_keluar IS NOT NULL');
        $this->db->where('DATE(waktu_keluar) >=', $mulai);
        $this->db->where('DATE(waktu_keluar) <=', $sampai);
        $this->db->order_by('waktu_keluar', 'ASC');
        $transaksi = $this->db->get('tb_parkir')->result_array();

        return [
            'total_pendapatan' => $summary['total_pendapatan'] ?? 0,
            'jumlah_keluar' => $summary['jumlah_keluar'] ?? 0,
            'transaksi' => $transaksi
        ];
    }
}
