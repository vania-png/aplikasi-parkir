<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function hari_ini()
    {
        return $this->db->select('SUM(biaya_total) as total, COUNT(*) as transaksi')
                // Hitung berdasarkan waktu_keluar agar pendapatan hari ini sesuai transaksi yang keluar hari ini
                ->where('DATE(waktu_keluar)', date('Y-m-d'))
                ->where('waktu_keluar IS NOT NULL')
                ->where('biaya_total >', 0)
                ->get('tb_parkir')
                ->row();
    }

    public function transaksi_hari_ini()
    {
        // Ambil transaksi yang KELUAR hari ini (bukan masuk hari ini) dengan join area, tarif, kendaraan
        $this->db->select('tb_parkir.*, tb_area_parkir.nama_area, tb_tarif.jenis_kendaraan, tb_kendaraan.plat_nomor, tb_user.nama_lengkap as nama_petugas');
        $this->db->from('tb_parkir');
        $this->db->join('tb_area_parkir', 'tb_area_parkir.id_area = tb_parkir.id_area', 'left');
        $this->db->join('tb_tarif', 'tb_tarif.id_tarif = tb_parkir.id_tarif', 'left');
        $this->db->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_parkir.id_kendaraan', 'left');
        $this->db->join('tb_user', 'tb_user.id_user = tb_parkir.id_user', 'left');
        // Filter: waktu_keluar hari ini dan sudah ada biaya
        $this->db->where('DATE(waktu_keluar)', date('Y-m-d'));
        $this->db->where('waktu_keluar IS NOT NULL');
        $this->db->where('biaya_total >', 0);
        $this->db->order_by('tb_parkir.waktu_keluar', 'DESC');
        $result = $this->db->get()->result();
        
        // Format array untuk ditampilkan
        $data = [];
        foreach ($result as $row) {
            $plat = !empty($row->plat_nomor) ? $row->plat_nomor : $row->no_polisi;
            $data[] = [
                'no_polisi' => $plat,
                'jenis_kendaraan' => $row->jenis_kendaraan,
                'waktu_masuk' => $row->waktu_masuk,
                'waktu_keluar' => $row->waktu_keluar,
                'biaya_total' => $row->biaya_total,
                'nama_petugas' => $row->nama_petugas,
            ];
        }
        return $data;
    }

    public function mingguan()
    {
        return $this->db->select('SUM(biaya_total) as total, COUNT(*) as transaksi')
                // Hitung berdasarkan waktu_keluar dalam 7 hari terakhir
                ->where('DATE(waktu_keluar) >=', date('Y-m-d', strtotime('-7 days')))
                ->where('waktu_keluar IS NOT NULL')
                ->where('biaya_total >', 0)
                ->get('tb_parkir')
                ->row();
    }

    public function bulanan()
    {
        return $this->db->select('SUM(biaya_total) as total, COUNT(*) as transaksi')
                // Hitung berdasarkan waktu_keluar untuk akumulasi bulan ini
                ->where('MONTH(waktu_keluar)', date('m'))
                ->where('YEAR(waktu_keluar)', date('Y'))
                ->where('waktu_keluar IS NOT NULL')
                ->where('biaya_total >', 0)
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
