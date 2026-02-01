<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

public function proses()
{
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('tb_user', [
        'email' => $email,
        'password' => $password,
        'status_aktif' => 1
    ])->row();

    if ($user) {

        // SET SESSION
        $this->session->set_userdata([
            'id_user' => $user->id_user,
            'username' => $user->nama_lengkap,
            'email' => $user->email,
            'role' => $user->role,
            'login' => true
        ]);

        // REDIRECT SESUAI ROLE
        if ($user->role == 'admin') {
            redirect(site_url('admin/dashboard'));
        } elseif ($user->role == 'petugas') {
            redirect(site_url('petugas/transaksi'));
        } elseif ($user->role == 'owner') {
            redirect(site_url('owner/laporan'));
        }

    } else {
        $this->session->set_flashdata('error','Email atau Password salah');
        redirect(site_url('auth'));
    }
}
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('auth'));
    }
}