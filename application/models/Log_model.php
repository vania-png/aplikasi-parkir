<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    private $table = 'tb_log_aktivitas';

    // simpan log
    public function simpan($id_user, $aktivitas) {
        $data = [
            'id_user'   => $id_user,
            'aktivitas' => $aktivitas,
            'waktu_aktivitas'     => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->table, $data);
    }

    // ambil semua log (join ke user)
    public function get_all() {
        return $this->db
            ->select('l.*, u.nama_lengkap')
            ->from($this->table . ' l')
            ->join('tb_user u', 'u.id_user = l.id_user', 'left')
            ->order_by('l.waktu_aktivitas', 'DESC')
            ->get()
            ->result();
    }
}
