
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    public function laporan()
    {
        $data['hari_ini']   = $this->Laporan_model->hari_ini();
        $data['mingguan']   = $this->Laporan_model->mingguan();
        $data['bulanan']    = $this->Laporan_model->bulanan();
        $data['transaksi_hari_ini'] = $this->Laporan_model->transaksi_hari_ini();

        $this->load->view('owner/layout/header', ['title' => 'Laporan']);
        $active = 'laporan';
        $this->load->view('owner/layout/sidebar', compact('active'));
        $this->load->view('owner/laporan/index', $data);
        $this->load->view('owner/layout/footer');
    }

    public function custom()
    {
        // Ambil filter dari GET
        $periode_mulai = $this->input->get('dari');
        $periode_selesai = $this->input->get('sampai');

        // Validasi tanggal
        if (!$periode_mulai || !$periode_selesai) {
            redirect('owner/laporan');
        }

        // Ambil data dari model
        $laporan = $this->Laporan_model->get_laporan_custom($periode_mulai, $periode_selesai);

        $data = [
            'periode_mulai' => $periode_mulai,
            'periode_selesai' => $periode_selesai,
            'jumlah_keluar' => $laporan['jumlah_keluar'] ?? 0,
            'total_pendapatan' => $laporan['total_pendapatan'] ?? 0,
            'transaksi' => $laporan['transaksi'] ?? []
        ];

        $this->load->view('owner/layout/header', ['title' => 'Laporan Kustom']);
        $active = 'laporan';
        $this->load->view('owner/layout/sidebar', compact('active'));
        $this->load->view('owner/laporan/custom', $data);
        $this->load->view('owner/layout/footer');
    }

    public function cetak()
    {
        // Ambil filter dari GET
        $periode_mulai = $this->input->get('dari');
        $periode_selesai = $this->input->get('sampai');

        // Validasi tanggal
        if (!$periode_mulai || !$periode_selesai) {
            redirect('owner/laporan');
        }

        // Ambil data dari model
        $laporan = $this->Laporan_model->get_laporan_custom($periode_mulai, $periode_selesai);

        $data = [
            'periode_mulai' => $periode_mulai,
            'periode_selesai' => $periode_selesai,
            'jumlah_keluar' => $laporan['jumlah_keluar'] ?? 0,
            'total_pendapatan' => $laporan['total_pendapatan'] ?? 0,
            'transaksi' => $laporan['transaksi'] ?? []
        ];

        $this->load->view('owner/laporan/cetak', $data);
    }
}
