<?php

/**
 * Class MStatus
 * Model untuk mengelola data status produk
 */
class MStatus extends CI_Model
{
    /**
     * Mengambil data status produk dari database
     *
     * @return CI_DB_result Objek hasil query dari database
     */
    public function getDataStatus()
    {
        // Mengembalikan seluruh data di dalam tabel status
        return $this->db->get('status');
    }
}
