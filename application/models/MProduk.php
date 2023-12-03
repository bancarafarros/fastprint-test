<?php

/**
 * Class MProduk
 * Model untuk mengelola data produk
 */
class MProduk extends CI_Model
{
    /**
     * Mengambil semua data produk dari database
     *
     * @return CI_DB_result Objek hasil query dari database
     */
    public function getDataProduk()
    {
        // Mengembalikan seluruh data di dalam tabel produk
        return $this->db->get('produk');
    }

    /**
     * Mengambil data produk yang dijual (dengan status_id = 1) dari database
     *
     * @return CI_DB_result Objek hasil query dari database
     */
    public function getDataProdukJual()
    {
        // Mengembalikan seluruh data di dalam tabel produk yang memiliki kolom status_id = 1
        return $this->db->get_where('produk', ['status_id' => 1]);
    }

    /**
     * Mengambil data produk berdasarkan kondisi tertentu dari database
     *
     * @param array $where Kondisi pencarian
     * @param string $table Nama tabel database
     * @return CI_DB_result Objek hasil query dari database
     */
    public function whereProduk($where, $table)
    {
        // Mengembalikan data sesuai dengan id dan tabel yang diminta dalam parameter $where dan $table
        return $this->db->get_where($table, $where);
    }
}
