<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $this->load->model('Transaksi_model');
        $this->load->model('Area_model');

        $data['active'] = 'dashboard';
        $data['total_kendaraan_aktif'] = $this->Transaksi_model->get_total_kendaraan();
        $data['total_slot_tersedia'] = $this->Area_model->get_total_slot_tersedia();
        $data['total_data_kendaraan'] = $this->Transaksi_model->get_total_data_kendaraan();
        $data['total_pendapatan'] = $this->Transaksi_model->get_total_pendapatan_hari_ini();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function test()
    {
        echo "ADMIN OKE";
    }
}