<?php

/**
 * Class MKategori
 * Model untuk mengelola data kategori produk
 */
class MKategori extends CI_Model
{
    /**
     * Mengambil data kategori dari database
     * @return CI_DB_result Objek hasil query dari database
     */
    public function getDataKategori()
    {
        // Mengembalikan seluruh data di dalam tabel kategori
        return $this->db->get('kategori');
    }
}
