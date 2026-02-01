<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_jenis_to_area_parkir extends CI_Migration
{
    public function up()
    {
        // Cek apakah kolom jenis sudah ada
        if (!$this->db->field_exists('jenis', 'tb_area_parkir'))
        {
            $this->dbforge->add_column('tb_area_parkir', array(
                'jenis' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'null' => true,
                    'after' => 'nama_area'
                )
            ));
        }
    }

    public function down()
    {
        // Jika rollback, hapus kolom jenis
        if ($this->db->field_exists('jenis', 'tb_area_parkir'))
        {
            $this->dbforge->drop_column('tb_area_parkir', 'jenis');
        }
    }
}
