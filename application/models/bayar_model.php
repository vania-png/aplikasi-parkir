<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

    protected $table = 'pembayaran';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_transaksi($id_transaksi)
    {
        $this->db->select('pembayaran.*, transaksi.no_polisi, transaksi.jenis_kendaraan');
        $this->db->from('pembayaran');
        $this->db->join('transaksi', 'transaksi.id = pembayaran.transaksi_id');
        $this->db->where('pembayaran.transaksi_id', $id_transaksi);
        return $this->db->get()->row();
    }
}
