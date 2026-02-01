<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Log_model');

        // proteksi: hanya admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['user'] = $this->User_model->get_all();
        $data['active'] = 'user';
        $this->load->view('admin/user/index', $data);
    }

    public function tambah()
    {
        $this->load->view('admin/layout/header', [
            'title'  => 'Tambah User',
            'active' => 'user'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/user/tambah');
        $this->load->view('admin/layout/footer');
    }

    public function simpan()
    {
        $nama_lengkap = $this->input->post('nama_lengkap');
        $username     = $this->input->post('username');
        $email        = $this->input->post('email');
        $password     = $this->input->post('password');
        $role         = $this->input->post('role');

        // Validasi wajib isi
        if (empty($nama_lengkap) || empty($username) || empty($email) || empty($password) || empty($role)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi!');
            redirect(site_url('admin/user/tambah'));
            return;
        }

        $data = [
            'nama_lengkap' => $nama_lengkap,
            'username'     => $username,
            'email'        => $email,
            'password'     => $password,
            'role'         => $role,
            'status_aktif' => 1
        ];

        if ($this->User_model->insert($data)) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambah user: ' . $data['nama_lengkap']);
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan user');
        }
        redirect(site_url('admin/user'));
    }

    public function edit($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/user'));
        }
        
        $data['user'] = $this->User_model->get_by_id($id);
        
        if (!$data['user']) {
            redirect(site_url('admin/user'));
        }

        $this->load->view('admin/layout/header', [
            'title'  => 'Edit User',
            'active' => 'user'
        ]);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/user/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function update($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/user'));
        }
        

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'email'        => $this->input->post('email'),
            'role'         => $this->input->post('role')
        ];

        if ($this->input->post('password') != '') {
            $data['password'] = $this->input->post('password');
        }

        if ($this->User_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'User berhasil diupdate');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengedit user: ' . $data['nama_lengkap']);
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate user');
        }
        redirect(site_url('admin/user'));
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            redirect(site_url('admin/user'));
        }
        
        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus user ID: ' . $id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }
        redirect(site_url('admin/user'));
    }
}