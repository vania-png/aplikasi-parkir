<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Pembayaran_model');
    }

    // halaman bayar
    public function bayar($id_transaksi)
    {
        $data['transaksi'] = $this->Transaksi_model->get_by_id($id_transaksi);

        if (!$data['transaksi']) {
            show_404();
        }

        // hitung total (contoh sederhana)
        $data['total'] = $data['transaksi']->biaya_estimasi;

        $this->load->view('petugas/pembayaran/bayar', $data);
    }

    // proses pembayaran
    public function proses()
    {
        $transaksi_id = $this->input->post('transaksi_id');
        $metode       = $this->input->post('metode');
        $total        = $this->input->post('total');

        $data = [
            'transaksi_id' => $transaksi_id,
            'metode'       => $metode,
            'total_bayar'  => $total,
            'waktu_bayar'  => date('Y-m-d H:i:s'),
            'status'       => 'lunas'
        ];

        // simpan pembayaran
        $this->Pembayaran_model->insert($data);

        // update transaksi jadi selesai
        $this->Transaksi_model->set_selesai($transaksi_id);

        redirect('petugas/pembayaran/struk/'.$transaksi_id);
    }

    // halaman struk
    public function struk($id_transaksi)
    {
        $data['pembayaran'] = $this->Pembayaran_model->get_by_transaksi($id_transaksi);

        if (!$data['pembayaran']) {
            show_404();
        }

        $this->load->view('petugas/pembayaran/struk', $data);
    }
}
