<?php
class Kendaraan_model extends CI_Model {

    private $table = 'tb_kendaraan';

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id_kendaraan' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_kendaraan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id_kendaraan' => $id]);
    }

    public function cek_plat_ada($plat_nomor, $exclude_id = null) {
        $this->db->where('plat_nomor', $plat_nomor);
        if ($exclude_id) {
            $this->db->where('id_kendaraan !=', $exclude_id);
        }
        return $this->db->get($this->table)->row();
    }
}
