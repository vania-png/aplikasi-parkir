<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kendaraan_model');
        $this->load->model('Tarif_model');
        $this->load->model('Log_model');
    }

    public function index() {
        $data['kendaraan'] = $this->Kendaraan_model->get_all();
        $this->load->view('admin/layout/header', [
            'title' => 'Data Kendaraan',
            'active' => 'kendaraan'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/kendaraan/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function tambah() {
        $data['jenis_kendaraan'] = $this->Tarif_model->get_jenis_kendaraan();
        $this->load->view('admin/layout/header', [
            'title' => 'Tambah Kendaraan',
            'active' => 'kendaraan'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/kendaraan/tambah', $data);
        $this->load->view('admin/layout/footer');
    }

    public function simpan() {
        $data = $this->input->post();
        
        // Validasi panjang harus 7-8 karakter (tanpa spasi)
        $plat_nomor = $data['plat_nomor'] ?? '';
        $plat_normal = preg_replace('/\s+/', '', $plat_nomor);
        if (strlen($plat_normal) < 7 || strlen($plat_normal) > 8) {
            if (strlen($plat_normal) < 7) {
                $this->session->set_flashdata('error', 'Plat minimal 7 karakter (tanpa spasi).');
            } else {
                $this->session->set_flashdata('error', 'Plat maksimal 8 karakter (tanpa spasi).');
            }
            redirect('admin/kendaraan/tambah');
            return;
        }

        // Cek apakah plat nomor sudah ada
        $plat_ada = $this->Kendaraan_model->cek_plat_ada($data['plat_nomor']);
        if ($plat_ada) {
            $this->session->set_flashdata('error', 'Nomor plat sudah terdaftar. Gunakan nomor plat yang lain.');
            redirect('admin/kendaraan/tambah');
            return;
        }
        
        $this->Kendaraan_model->insert($data);
        $this->session->set_flashdata('success', 'Kendaraan berhasil ditambahkan');
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambahkan Kendaraan: ' . ($data['plat_nomor'] ?? '') . ' (' . ($data['jenis_kendaraan'] ?? '') . ')');
        redirect('admin/kendaraan');
    }

    public function edit($id) {
        $data['kendaraan'] = $this->Kendaraan_model->get_by_id($id);
        if (!$data['kendaraan']) {
            show_404();
        }
        $data['jenis_kendaraan'] = $this->Tarif_model->get_jenis_kendaraan();
        $this->load->view('admin/layout/header', [
            'title' => 'Edit Kendaraan',
            'active' => 'kendaraan'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/kendaraan/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function update($id) {
        $data = $this->input->post();
        
        // Validasi panjang harus 7-8 karakter (tanpa spasi)
        $plat_nomor = $data['plat_nomor'] ?? '';
        $plat_normal = preg_replace('/\s+/', '', $plat_nomor);
        if (strlen($plat_normal) < 7 || strlen($plat_normal) > 8) {
            if (strlen($plat_normal) < 7) {
                $this->session->set_flashdata('error', 'Plat minimal 7 karakter (tanpa spasi).');
            } else {
                $this->session->set_flashdata('error', 'Plat maksimal 8 karakter (tanpa spasi).');
            }
            redirect('admin/kendaraan/edit/' . $id);
            return;
        }

        // Cek apakah plat nomor sudah ada (exclude ID saat ini)
        $plat_ada = $this->Kendaraan_model->cek_plat_ada($data['plat_nomor'], $id);
        if ($plat_ada) {
            $this->session->set_flashdata('error', 'Nomor plat sudah terdaftar. Gunakan nomor plat yang lain.');
            redirect('admin/kendaraan/edit/' . $id);
            return;
        }
        
        $this->Kendaraan_model->update($id, $data);
        $this->session->set_flashdata('success', 'Kendaraan berhasil diperbarui');
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengubah Kendaraan: ' . ($data['plat_nomor'] ?? '') . ' (' . ($data['jenis_kendaraan'] ?? '') . ')');
        redirect('admin/kendaraan');
    }

    public function hapus($id) {
        $kendaraan = $this->Kendaraan_model->get_by_id($id);
        $this->Kendaraan_model->delete($id);
        $this->session->set_flashdata('success', 'Kendaraan berhasil dihapus');
        $plat = $kendaraan ? $kendaraan->plat_nomor : 'Unknown';
        $jenis = $kendaraan ? $kendaraan->jenis_kendaraan : 'Unknown';
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus Kendaraan: ' . $plat . ' (' . $jenis . ')');
        redirect('admin/kendaraan');
    }

    public function cek_plat() {
        $plat_nomor = $this->input->post('plat_nomor');
        $exclude_id = $this->input->post('exclude_id');
        
        $result = $this->Kendaraan_model->cek_plat_ada($plat_nomor, $exclude_id);
        
        if ($result) {
            echo json_encode(['status' => 'ada', 'message' => 'Nomor plat sudah terdaftar']);
        } else {
            echo json_encode(['status' => 'tidak_ada', 'message' => 'Nomor plat tersedia']);
        }
    }
}
