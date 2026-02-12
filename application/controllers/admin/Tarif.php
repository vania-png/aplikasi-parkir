<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tarif_model');
        $this->load->model('Log_model');

        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['tarif'] = $this->Tarif_model->get_all();
        $data['active'] = 'tarif';
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/tarif/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function tambah()
    {
        $data['active'] = 'tarif';
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/tarif/tambah', $data);
        $this->load->view('admin/layout/footer');
    }

    public function simpan()
    {
        $data = [
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'tarif_per_jam'   => $this->input->post('tarif_per_jam'),
            'tarif_per_hari'  => 0
        ];

        if ($this->Tarif_model->insert($data)) {
            $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambahkan Tarif: ' . $data['jenis_kendaraan'] . ' - Rp ' . number_format($data['tarif_per_jam'], 0, ',', '.') . '/jam');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan tarif');
        }
        redirect(site_url('admin/tarif'));
    }

    public function edit($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/tarif'));
        }
        
        $data['tarif'] = $this->Tarif_model->get_by_id($id);
        $data['active'] = 'tarif';
        
        if (!$data['tarif']) {
            redirect(site_url('admin/tarif'));
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/tarif/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function update($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/tarif'));
        }
        
        $data = [
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'tarif_per_jam'   => $this->input->post('tarif_per_jam'),
            'tarif_per_hari'  => 0
        ];

        if ($this->Tarif_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Tarif berhasil diupdate');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengubah Tarif: ' . $data['jenis_kendaraan'] . ' - Rp ' . number_format($data['tarif_per_jam'], 0, ',', '.') . '/jam');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate tarif');
        }
        redirect(site_url('admin/tarif'));
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/tarif'));
        }
        
        $tarif = $this->Tarif_model->get_by_id($id);
        
        if ($this->Tarif_model->delete($id)) {
            $this->session->set_flashdata('success', 'Tarif berhasil dihapus');
            $jenis = $tarif ? $tarif->jenis_kendaraan : 'Unknown';
            $harga = $tarif ? number_format($tarif->tarif_per_jam, 0, ',', '.') : 'Unknown';
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus Tarif: ' . $jenis . ' - Rp ' . $harga . '/jam');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tarif');
        }
        redirect(site_url('admin/tarif'));
    }
}
