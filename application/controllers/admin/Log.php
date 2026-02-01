<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // 🔐 CEK LOGIN
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        // 🔐 CEK ROLE (ADMIN SAJA)
        if ($this->session->userdata('role') != 'admin') {
            show_error('Akses ditolak', 403);
        }

        // LOAD MODEL
        $this->load->model('Log_model');
    }

    public function index() {

        $data['log'] = $this->Log_model->get_all();

        $this->load->view('admin/layout/header', [
            'title'  => 'Log Aktivitas',
            'active' => 'log'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/log_aktivitas/index', $data);
        $this->load->view('admin/layout/footer');
    }
}
