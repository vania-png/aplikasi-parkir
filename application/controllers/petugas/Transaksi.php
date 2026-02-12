<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Kendaraan_model');
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
        // Ambil SEMUA transaksi aktif (tidak peduli tanggalnya, selama belum keluar)
        $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();

        // Hitung durasi dan biaya untuk setiap transaksi aktif
        foreach ($transaksi_aktif as $t) {
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

        $data['transaksi'] = $transaksi_aktif;
        $data['total_transaksi_hari_ini'] = count($transaksi_aktif);
        $data['total_aktif'] = count($transaksi_aktif);
        $data['total_pendapatan'] = array_sum(array_column($transaksi_aktif, 'biaya_total'));
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
        $data['kendaraan'] = $this->Kendaraan_model->get_all();
        $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();

        // Filter: Only include VALID active transactions (biaya > 0)
        $transaksi_aktif_valid = array_filter($transaksi_aktif, function($t) {
            return $t->biaya_total > 0;
        });

        // Hitung durasi dan biaya estimasi untuk setiap transaksi aktif
        foreach ($transaksi_aktif_valid as $t) {
            $durasi = ceil((time() - strtotime($t->waktu_masuk)) / 3600);
            if ($durasi < 1) $durasi = 1;
            $tarif = $this->Transaksi_model->get_tarif_by_jenis($t->jenis_kendaraan);
            $t->durasi_jam = $durasi;
            $t->biaya_estimasi = $durasi * $tarif->tarif_per_jam;
        }

        $data['transaksi_aktif'] = $transaksi_aktif_valid;
        $data['plat_aktif'] = array_map(function($t) { return $t->no_polisi; }, $transaksi_aktif_valid);
        $data['active'] = 'data';

        $this->load->view('petugas/layout/header', [
            'title' => 'Data Parkir'
        ]);
        $this->load->view('petugas/layout/sidebar', $data);
        $this->load->view('petugas/transaksi/data_parkir', $data);
        $this->load->view('petugas/layout/footer');
    }

    // =========================
    // STRUK MASUK (PREVIEW SEBELUM SIMPAN)
    // =========================
    public function struk_masuk()
    {
        $no_polisi = $this->input->post('no_polisi');
        
        // Validasi: cek apakah plat nomor sudah ada di transaksi aktif
        $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();
        foreach ($transaksi_aktif as $t) {
            if ($t->no_polisi === $no_polisi) {
                // Plat nomor sedang aktif
                $this->session->set_flashdata('error', 'Plat nomor ' . $no_polisi . ' masih dalam transaksi aktif. Silakan selesaikan transaksi sebelumnya.');
                redirect('petugas/transaksi/data_parkir');
                return;
            }
        }
        
        $jenis_kendaraan = $this->input->post('jenis_kendaraan');
        $jam_masuk = $this->input->post('jam_masuk');
        $tanggal = $this->input->post('tanggal');

        $tarif = $this->Transaksi_model->get_tarif_by_jenis($jenis_kendaraan);
        
        // Validasi: tarif harus ada
        if (!$tarif) {
            $this->session->set_flashdata('error', 'Jenis kendaraan tidak ditemukan atau tidak memiliki tarif. Silakan hubungi admin.');
            redirect('petugas/transaksi/data_parkir');
            return;
        }

        // Simpan data ke session
        $this->session->set_userdata('form_masuk', [
            'no_polisi' => $no_polisi,
            'jenis_kendaraan' => $jenis_kendaraan,
            'id_area' => $this->input->post('area_id'),
            'id_tarif' => $tarif->id_tarif,
            'waktu_masuk' => $tanggal . ' ' . $jam_masuk,
            'id_user' => $this->session->userdata('id_user'),
            'tarif_per_jam' => $tarif->tarif_per_jam ?? 0,
            'nama_area' => $this->Transaksi_model->get_area_by_id($this->input->post('area_id'))->nama_area ?? '-',
            'tanggal' => $tanggal,
            'jam_masuk' => $jam_masuk
        ]);

        // REDIRECT via GET untuk menghindari POST cache issue
        redirect('petugas/transaksi/struk_masuk_preview');
    }

    // =========================
    // TAMPILKAN PREVIEW STRUK MASUK (GET)
    // =========================
    public function struk_masuk_preview()
    {
        // Ambil data dari session
        $form_data = $this->session->userdata('form_masuk');
        
        if (!$form_data) {
            $this->session->set_flashdata('error', 'Session expired. Silakan input ulang.');
            redirect('petugas/transaksi/data_parkir');
            return;
        }

        // Siapkan data untuk ditampilkan di struk preview
        $data['no_polisi'] = $form_data['no_polisi'];
        $data['jenis_kendaraan'] = $form_data['jenis_kendaraan'];
        $data['tanggal'] = $form_data['tanggal'];
        $data['jam_masuk'] = $form_data['jam_masuk'];
        $data['tarif_per_jam'] = $form_data['tarif_per_jam'];
        $data['nama_area'] = $form_data['nama_area'];

        $this->load->view('petugas/transaksi/struk_masuk', $data);
    }

    // =========================
    // CETAK STRUK MASUK (HALAMAN PRINT)
    // =========================
    public function cetak_masuk()
    {
        // Ambil data dari session
        $form_data = $this->session->userdata('form_masuk');
        
        if (!$form_data) {
            echo json_encode(['status' => 'error', 'message' => 'Session expired']);
            return;
        }

        // Simpan ke database sekarang
        $data = [
            'no_polisi'       => $form_data['no_polisi'],
            'jenis_kendaraan' => $form_data['jenis_kendaraan'],
            'id_area'         => $form_data['id_area'],
            'id_tarif'        => $form_data['id_tarif'],
            'waktu_masuk'     => $form_data['waktu_masuk'],
            'waktu_keluar'    => NULL,
            'durasi_jam'      => 0,
            'biaya_total'     => 0,
            'id_user'         => $form_data['id_user']
        ];

        $id = $this->Transaksi_model->insert($data);
        
        // Simpan ID ke session untuk diakses di cetak_printed
        $this->session->set_userdata('cetak_id', $id);

        // Return JSON response (untuk AJAX)
        echo json_encode(['status' => 'success', 'id' => $id]);
    }

    // =========================
    // TAMPILKAN STRUK PRINT
    // =========================
    public function cetak_printed()
    {
        $id = $this->session->userdata('cetak_id');
        
        if (!$id) {
            $this->session->set_flashdata('error', 'Session expired. Silakan input ulang.');
            redirect('petugas/transaksi/data_parkir');
            return;
        }

        // Ambil data yang baru saja disimpan
        $transaksi = $this->Transaksi_model->get_by_id($id);
        
        if (!$transaksi) {
            show_404();
        }

        $tarif = $this->Transaksi_model->get_tarif_by_jenis($transaksi->jenis_kendaraan);
        
        $data_struk['no_polisi'] = $transaksi->no_polisi;
        $data_struk['jenis_kendaraan'] = $transaksi->jenis_kendaraan;
        $data_struk['nama_area'] = $transaksi->nama_area ?? '-';
        $data_struk['waktu_masuk'] = $transaksi->waktu_masuk;
        $data_struk['tarif_per_jam'] = $tarif->tarif_per_jam ?? 0;

        // Clear session
        $this->session->unset_userdata('form_masuk');
        $this->session->unset_userdata('cetak_id');

        $this->load->view('petugas/transaksi/struk_masuk2', $data_struk);
    }

    // =========================
    // BATAL CETAK STRUK MASUK
    // =========================
    public function batal_cetak()
    {
        // Clear session form dan cetak_id
        $this->session->unset_userdata('form_masuk');
        $this->session->unset_userdata('cetak_id');
        
        // Redirect ke data_parkir (clean GET request)
        redirect('petugas/transaksi/data_parkir');
    }
    public function simpan()
    {
        // Ambil data dari session yang sudah divalidasi
        $form_data = $this->session->userdata('form_masuk');
        
        if (!$form_data) {
            $this->session->set_flashdata('error', 'Session expired. Silakan input ulang.');
            redirect('petugas/transaksi/data_parkir');
            return;
        }

        $data = [
            'no_polisi'       => $form_data['no_polisi'],
            'jenis_kendaraan' => $form_data['jenis_kendaraan'],
            'id_area'         => $form_data['id_area'],
            'id_tarif'        => $form_data['id_tarif'],
            'waktu_masuk'     => $form_data['waktu_masuk'],
            'waktu_keluar'    => NULL,
            'durasi_jam'      => 0,
            'biaya_total'     => 0,
            'id_user'         => $form_data['id_user']
        ];

        $id = $this->Transaksi_model->insert($data);
        
        // Hapus session form
        $this->session->unset_userdata('form_masuk');

        $this->session->set_flashdata('success', 'Kendaraan berhasil dicatat masuk!');
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

        // Hitung biaya sementara menggunakan tarif_per_jam dari transaksi (id_tarif)
        $waktu_sekarang = date('Y-m-d H:i:s');
        $durasi_jam = ceil((strtotime($waktu_sekarang) - strtotime($data['transaksi']->waktu_masuk)) / 3600);
        if ($durasi_jam < 1) $durasi_jam = 1;

        // Gunakan tarif_per_jam yang sudah dimuat dari JOIN dengan tb_tarif
        $tarif_per_jam = $data['transaksi']->tarif_per_jam ?? 0;
        
        // Hitung total biaya berdasarkan durasi dan tarif per jam
        $data['biaya_total'] = $durasi_jam * $tarif_per_jam;
        $data['tarif_per_jam'] = $tarif_per_jam;
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
        $biaya_total = $this->input->post('biaya_total'); // Ambil dari form (hasil perhitungan di bayar page)

        $transaksi = $this->Transaksi_model->get_by_id($id);
        if (!$transaksi) {
            show_404();
        }

        // Validasi: uang yang diberikan harus >= biaya total
        if ($uang_diberikan < $biaya_total) {
            $this->session->set_flashdata('error', 'Uang yang diberikan kurang!');
            redirect('petugas/transaksi/bayar/' . $id);
        }

        $waktu_keluar = date('Y-m-d H:i:s');
        $durasi_jam = ceil((strtotime($waktu_keluar) - strtotime($transaksi->waktu_masuk)) / 3600);
        if ($durasi_jam < 1) $durasi_jam = 1;

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

        // Redirect ke halaman struk_keluar
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

        $this->load->view('petugas/transaksi/struk_keluar', $data);
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
            // Tampilkan SEMUA kendaraan aktif (waktu_keluar IS NULL)
            $transaksi = $this->Transaksi_model->get_transaksi_aktif();
        } elseif ($status == 'Keluar') {
            // Tampilkan kendaraan yang sudah keluar (waktu_keluar IS NOT NULL) - ALL time, not just today
            $transaksi = $this->Transaksi_model->get_transaksi_keluar();
        } else {
            // Gabungkan SEMUA kendaraan aktif dan yang sudah keluar (ALL time)
            $transaksi_aktif = $this->Transaksi_model->get_transaksi_aktif();
            $transaksi_keluar = $this->Transaksi_model->get_transaksi_keluar();
            $transaksi = array_merge($transaksi_aktif, $transaksi_keluar);
        }
        
        // Filter plat (jika ada pencarian)
        if ($cari_plat) {
            $transaksi = array_filter($transaksi, function($t) use ($cari_plat) {
                $plat = $t->plat_nomor ?? $t->no_polisi ?? '';
                return stripos($plat, $cari_plat) !== false;
            });
        }

        // Hitung total transaksi dan pendapatan berdasarkan data yang ditampilkan (OTOMATIS)
        $data['total_transaksi'] = count($transaksi); // Total dari data yang ditampilkan
        $data['transaksi_aktif'] = count(array_filter($transaksi, function($t) {
            return !$t->waktu_keluar; // Hitung yang masih aktif (belum keluar)
        }));
        $data['pendapatan_hari_ini'] = array_sum(array_column($transaksi, 'biaya_total')); // Sum biaya_total dari yang ditampilkan
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
