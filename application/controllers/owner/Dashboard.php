<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') != 'owner') {
            redirect('auth');
        }
    }

    public function index()
    {
        // Redirect langsung ke laporan
        redirect(site_url('owner/laporan'));
    }
}