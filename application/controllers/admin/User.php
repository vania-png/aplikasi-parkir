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

        // Cek apakah email sudah terdaftar
        $email_ada = $this->User_model->cek_email_ada($email);
        if ($email_ada) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar. Gunakan email yang lain.');
            redirect(site_url('admin/user/tambah'));
            return;
        }

        // Cek apakah username sudah terdaftar
        $username_ada = $this->User_model->cek_username_ada($username);
        if ($username_ada) {
            $this->session->set_flashdata('error', 'Username sudah terdaftar. Gunakan username yang lain.');
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
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menambahkan User: ' . $data['nama_lengkap'] . ' (Role: ' . ucfirst($data['role']) . ')');
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

        // Cek apakah email sudah terdaftar (exclude ID saat ini)
        $email_ada = $this->User_model->cek_email_ada($data['email'], $id);
        if ($email_ada) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar. Gunakan email yang lain.');
            redirect(site_url('admin/user/edit/' . $id));
            return;
        }

        // Cek apakah username sudah terdaftar (exclude ID saat ini)
        $username_ada = $this->User_model->cek_username_ada($data['username'], $id);
        if ($username_ada) {
            $this->session->set_flashdata('error', 'Username sudah terdaftar. Gunakan username yang lain.');
            redirect(site_url('admin/user/edit/' . $id));
            return;
        }

        if ($this->User_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'User berhasil diupdate');
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Mengubah User: ' . $data['nama_lengkap'] . ' (Role: ' . ucfirst($data['role']) . ')');
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
        
        $user = $this->User_model->get_by_id($id);
        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
            $nama = $user ? $user->nama_lengkap : 'Unknown';
            $role = $user ? ucfirst($user->role) : 'Unknown';
            $this->Log_model->simpan($this->session->userdata('id_user'), 'Menghapus User: ' . $nama . ' (Role: ' . $role . ')');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }
        redirect(site_url('admin/user'));
    }

    public function cek_email()
    {
        $email = $this->input->post('email');
        $exclude_id = $this->input->post('exclude_id');
        
        $result = $this->User_model->cek_email_ada($email, $exclude_id);
        
        if ($result) {
            echo json_encode(['status' => 'ada', 'message' => 'Email sudah terdaftar']);
        } else {
            echo json_encode(['status' => 'tidak_ada', 'message' => 'Email tersedia']);
        }
    }

    public function cek_username()
    {
        $username = $this->input->post('username');
        $exclude_id = $this->input->post('exclude_id');
        
        $result = $this->User_model->cek_username_ada($username, $exclude_id);
        
        if ($result) {
            echo json_encode(['status' => 'ada', 'message' => 'Username sudah terdaftar']);
        } else {
            echo json_encode(['status' => 'tidak_ada', 'message' => 'Username tersedia']);
        }
    }
}
