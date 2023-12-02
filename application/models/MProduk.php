<?php
class MProduk extends CI_Model
{
    public function getDataProduk()
    {
        return $this->db->get('produk');
    }

    public function getDataProdukJual()
    {
        return $this->db->get_where('produk', ['status_id' => 1]);
    }
}
