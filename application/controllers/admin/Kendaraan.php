<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kendaraan_model');
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
        $this->load->view('admin/layout/header', [
            'title' => 'Tambah Kendaraan',
            'active' => 'kendaraan'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/kendaraan/tambah');
        $this->load->view('admin/layout/footer');
    }

    public function simpan() {
        $data = $this->input->post();
        $this->Kendaraan_model->insert($data);
        $this->session->set_flashdata('success', 'Kendaraan berhasil ditambahkan');
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambah kendaraan: ' . ($data['plat_nomor'] ?? ''));
        redirect('admin/kendaraan');
    }

    public function edit($id) {
        $data['kendaraan'] = $this->Kendaraan_model->get_by_id($id);
        if (!$data['kendaraan']) {
            show_404();
        }
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
        $this->Kendaraan_model->update($id, $data);
        $this->session->set_flashdata('success', 'Kendaraan berhasil diperbarui');
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengedit kendaraan: ' . ($data['plat_nomor'] ?? ''));
        redirect('admin/kendaraan');
    }

    public function hapus($id) {
        $this->Kendaraan_model->delete($id);
        $this->session->set_flashdata('success', 'Kendaraan berhasil dihapus');
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus kendaraan ID: ' . $id);
        redirect('admin/kendaraan');
    }
}
