<?php
class MKategori extends CI_Model
{
    public function getDataKategori()
    {
        return $this->db->get('kategori');
    }
}
