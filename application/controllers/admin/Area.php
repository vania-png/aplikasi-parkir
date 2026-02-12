<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Area_model');
        $this->load->model('Log_model');
    }

    // =====================
    // HALAMAN LIST AREA
    // =====================
    public function index()
    {
        $data['area'] = $this->Area_model->getAll();
        $data['active'] = 'area';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/area/index', $data);
        $this->load->view('admin/layout/footer');
    }

    // =====================
    // HALAMAN TAMBAH AREA
    // =====================
    public function tambah()
    {
        $data['active'] = 'area';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/area/tambah', $data);
        $this->load->view('admin/layout/footer');
    }

    // =====================
    // SIMPAN DATA AREA
    // =====================
    public function simpan()
    {
        $data = [
            'nama_area' => $this->input->post('nama_area'),
            'jenis'     => 'Umum', // default
            'kapasitas' => $this->input->post('kapasitas'),
            'terisi'    => $this->input->post('terisi'),
            'status'    => 1, // default aktif
        ];

        $this->Area_model->insert($data);
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambahkan Area Parkir: ' . $data['nama_area'] . ' (Kapasitas: ' . $data['kapasitas'] . ')');
        redirect('admin/area');
    }

    // =====================
    // HALAMAN EDIT AREA
    // =====================
    public function edit($id)
    {
        $data['area'] = $this->Area_model->getById($id);
        $data['active'] = 'area';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/area/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    // =====================
    // UPDATE DATA AREA
    // =====================
    public function update($id)
    {
        $data = [
            'nama_area' => $this->input->post('nama_area'),
            'jenis'     => 'Umum', // default
            'kapasitas' => $this->input->post('kapasitas'),
            'terisi'    => $this->input->post('terisi'),
            'status'    => 1, // default aktif
        ];

        $this->Area_model->update($id, $data);
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengubah Area Parkir: ' . $data['nama_area'] . ' (Kapasitas: ' . $data['kapasitas'] . ')');
        redirect('admin/area');
    }

    // =====================
    // HAPUS AREA
    // =====================
    public function hapus($id)
    {
        $area = $this->Area_model->getById($id);
        $this->Area_model->delete($id);
        $nama = $area ? $area->nama_area : 'Unknown';
        $kapasitas = $area ? $area->kapasitas : 'Unknown';
        $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus Area Parkir: ' . $nama . ' (Kapasitas: ' . $kapasitas . ')');
        redirect('admin/area');
    }
}
