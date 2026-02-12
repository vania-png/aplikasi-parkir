<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_model extends CI_Model {

    private $table = 'tb_tarif';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_tarif' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_tarif', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id_tarif', $id)->delete($this->table);
    }

    public function get_jenis_kendaraan()
    {
        $result = $this->db->select('jenis_kendaraan')
                           ->distinct()
                           ->order_by('jenis_kendaraan', 'ASC')
                           ->get($this->table)
                           ->result();
        return $result;
    }
}
