<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // proteksi login
        if (!$this->session->userdata('login')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $role = $this->session->userdata('role');
        
        if ($role == 'admin') {
            $this->load->view('admin/dashboard');
        } elseif ($role == 'owner') {
            $this->load->view('owner/dashboard');
        } elseif ($role == 'petugas') {
            $this->load->view('petugas/dashboard');
        } else {
            redirect('auth');
        }
    }
}