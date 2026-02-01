<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->library('session');

        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
    }

    // =========================
    // FORM TRANSAKSI
    // =========================
    public function index()
    {
        $transaksi = $this->Transaksi_model->get_transaksi_hari_ini();

        // Hitung durasi dan biaya untuk transaksi aktif
        foreach ($transaksi as $t) {
            if ($t->status == 'aktif') {
                $durasi = ceil((time() - strtotime($t->waktu_masuk)) / 3600);
                if ($durasi < 1) $durasi = 1;
                $tarif = $this->Transaksi_model->get_tarif_by_jenis($t->jenis_kendaraan);
                if ($tarif) {
                    $t->durasi_jam = $durasi;
                    $t->biaya_total = $durasi * $tarif->tarif_per_jam;
                } else {
                    $t->durasi_jam = $durasi;
                    $t->biaya_total = 0;
                }
            }
        }

        $data['transaksi'] = $transaksi;
        $data['total_transaksi_hari_ini'] = count($transaksi);
        $data['total_aktif'] = count(array_filter($transaksi, function($t) { return $t->status == 'aktif'; }));
        $data['total_pendapatan'] = array_sum(array_column($transaksi, 'biaya_total'));
        $data['active'] = 'transaksi';

        $this->load->view('petugas/layout/header', [
            'title' => 'Transaksi Parkir'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/index', $data);
        $this->load->view('petugas/layout/footer');
    }

    // =========================
    // DATA PARKIR FORM
    // =========================
    public function data_parkir()
    {
        $data['area']   = $this->Transaksi_model->get_area();
        $data['tarif']  = $this->Transaksi_model->get_tarif();
        $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();

        // Hitung durasi dan biaya estimasi untuk setiap transaksi aktif
        foreach ($transaksi_aktif as $t) {
            $durasi = ceil((time() - strtotime($t->waktu_masuk)) / 3600);
            if ($durasi < 1) $durasi = 1;
            $tarif = $this->Transaksi_model->get_tarif_by_jenis($t->jenis_kendaraan);
            $t->durasi_jam = $durasi;
            $t->biaya_estimasi = $durasi * $tarif->tarif_per_jam;
        }

        $data['transaksi_aktif'] = $transaksi_aktif;
        $data['active'] = 'data';

        $this->load->view('petugas/layout/header', [
            'title' => 'Data Parkir'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/data_parkir', $data);
        $this->load->view('petugas/layout/footer');
    }

    // =========================
    // SIMPAN TRANSAKSI
    // =========================
    public function simpan()
    {
        $jam_masuk  = $this->input->post('jam_masuk');

        $tarif = $this->Transaksi_model->get_tarif_by_jenis(
            $this->input->post('jenis_kendaraan')
        );

        $data = [
            'no_polisi'       => $this->input->post('no_polisi'),
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'id_area'         => $this->input->post('area_id'),
            'id_tarif'        => $tarif->id_tarif,
            'waktu_masuk'     => $this->input->post('tanggal') . ' ' . $jam_masuk,
            'waktu_keluar'    => NULL, // Parkir masuk, belum keluar
            'durasi_jam'      => 0, // Belum ada durasi
            'biaya_total'     => 0, // Belum ada biaya
            'id_user'         => $this->session->userdata('id_user')
        ];

        $id = $this->Transaksi_model->insert($data);

        redirect(site_url('petugas/transaksi'));
    }

    // =========================
    // DETAIL TRANSAKSI
    // =========================
    public function detail($id)
    {
        $data['transaksi'] = $this->Transaksi_model->get_by_id($id);

        if (!$data['transaksi']) {
            show_404();
        }

        $data['active'] = 'transaksi';

        $this->load->view('petugas/layout/header', [
            'title' => 'Detail Transaksi'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/detail', $data);
        $this->load->view('petugas/layout/footer');
    }



    // =========================
    // KELUAR PARKIR
    // =========================
    public function keluar($id)
    {
        $transaksi = $this->Transaksi_model->get_by_id($id);
        if (!$transaksi) {
            show_404();
        }

        // Redirect ke halaman bayar
        redirect('petugas/transaksi/bayar/' . $id);
    }

    // =========================
    // HALAMAN BAYAR
    // =========================
    public function bayar($id)
    {
        $data['transaksi'] = $this->Transaksi_model->get_by_id($id);

        if (!$data['transaksi']) {
            show_404();
        }

        // Hitung biaya sementara
        $waktu_sekarang = date('Y-m-d H:i:s');
        $durasi_jam = ceil((strtotime($waktu_sekarang) - strtotime($data['transaksi']->waktu_masuk)) / 3600);
        if ($durasi_jam < 1) $durasi_jam = 1;

        $tarif = $this->Transaksi_model->get_tarif_by_jenis($data['transaksi']->jenis_kendaraan);
        if ($tarif) {
            $data['biaya_total'] = $durasi_jam * $tarif->tarif_per_jam;
        } else {
            $data['biaya_total'] = 0; // Default jika tarif tidak ditemukan
        }
        $data['durasi_jam'] = $durasi_jam;
        $data['active'] = 'transaksi';

        $this->load->view('petugas/layout/header', [
            'title' => 'Pembayaran Parkir'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/bayar', $data);
        $this->load->view('petugas/layout/footer');
    }

    // =========================
    // PROSES BAYAR
    // =========================
    public function proses_bayar()
    {
        $id = $this->input->post('id_parkir');
        $uang_diberikan = $this->input->post('uang_diberikan');

        $transaksi = $this->Transaksi_model->get_by_id($id);
        if (!$transaksi) {
            show_404();
        }

        $waktu_keluar = date('Y-m-d H:i:s');
        $durasi_jam = ceil((strtotime($waktu_keluar) - strtotime($transaksi->waktu_masuk)) / 3600);
        if ($durasi_jam < 1) $durasi_jam = 1;

        $tarif = $this->Transaksi_model->get_tarif_by_jenis($transaksi->jenis_kendaraan);
        $biaya_total = $durasi_jam * $tarif->tarif_per_jam;

        if ($uang_diberikan < $biaya_total) {
            $this->session->set_flashdata('error', 'Uang yang diberikan kurang!');
            redirect('petugas/transaksi/bayar/' . $id);
        }

        $kembalian = $uang_diberikan - $biaya_total;

        // Update transaksi
        $this->db->where('id_parkir', $id);
        $this->db->update('tb_parkir', [
            'waktu_keluar' => $waktu_keluar,
            'durasi_jam' => $durasi_jam,
            'biaya_total' => $biaya_total,
            'uang_diberikan' => $uang_diberikan,
            'kembalian' => $kembalian,
            'status' => 'selesai'
        ]);

        // Set flashdata untuk struk
        $this->session->set_flashdata('kembalian', $kembalian);
        $this->session->set_flashdata('uang_diberikan', $uang_diberikan);

        redirect('petugas/transaksi/struk/' . $id);
    }

    // =========================
    // STRUK
    // =========================
    public function struk($id)
    {
        $data['transaksi'] = $this->Transaksi_model->get_by_id($id);

        if (!$data['transaksi']) {
            show_404();
        }

        $data['kembalian'] = $this->session->flashdata('kembalian');
        $data['uang_diberikan'] = $this->session->flashdata('uang_diberikan');

        $this->load->view('petugas/transaksi/struk', $data);
    }

    // =========================
    // REKAPAN TRANSAKSI
    // =========================
    public function rekapan()
    {

        $status = $this->input->get('status');
        $cari_plat = $this->input->get('cari_plat');

        // Ambil data sesuai filter
        if ($status == 'Aktif') {
            $transaksi = $this->Transaksi_model->get_transaksi_aktif();
        } elseif ($status == 'Keluar') {
            $transaksi = array_filter($this->Transaksi_model->get_transaksi_hari_ini(), function($t) {
                return $t->waktu_keluar;
            });
        } else {
            // Gabungkan kendaraan aktif dan keluar hari ini
            $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();
            $transaksi_keluar = array_filter($this->Transaksi_model->get_transaksi_hari_ini(), function($t) {
                return $t->waktu_keluar;
            });
            $transaksi = array_merge($transaksi_aktif, $transaksi_keluar);
        }
        // Filter plat
        if ($cari_plat) {
            $transaksi = array_filter($transaksi, function($t) use ($cari_plat) {
                $plat = $t->plat_nomor ?? $t->no_polisi ?? '';
                return stripos($plat, $cari_plat) !== false;
            });
        }

        $data['total_transaksi'] = $this->Transaksi_model->get_total_transaksi_hari_ini();
        $data['transaksi_aktif'] = count($this->Transaksi_model->get_transaksi_aktif());
        $data['pendapatan_hari_ini'] = $this->Transaksi_model->get_total_pendapatan_hari_ini();
        $data['jumlah_ditemukan'] = count($transaksi);
        $data['transaksi_list'] = array_map(function($t) {
            // Hitung durasi
            $durasi = '-';
            if ($t->waktu_keluar && $t->waktu_masuk) {
                $start = strtotime($t->waktu_masuk);
                $end = strtotime($t->waktu_keluar);
                $diff = $end - $start;
                $jam = floor($diff / 3600);
                $menit = floor(($diff % 3600) / 60);
                $durasi = $jam . 'j ' . $menit . 'm';
            }
            return [
                'no_polisi' => $t->plat_nomor ?? $t->no_polisi ?? '-',
                'waktu_masuk' => $t->waktu_masuk,
                'waktu_keluar' => $t->waktu_keluar,
                'durasi' => $durasi,
                'biaya_total' => $t->biaya_total ?? 0,
                'status' => $t->waktu_keluar ? 'Keluar' : 'Aktif'
            ];
        }, $transaksi);
        $data['status'] = $status;
        $data['cari_plat'] = $cari_plat;
        $data['active'] = 'log';

        $this->load->view('petugas/layout/header', [
            'title' => 'Rekapan Transaksi'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/rekapan', $data);
        $this->load->view('petugas/layout/footer');
    }
}
