<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Class ProdukAPI
 * Controller untuk mengelola data produk
 */
class ProdukAPI extends CI_Controller
{
    /**
     * Menampilkan data dari API dan menyimpannya ke dalam database
     * @return array data produk dari API
     */
    public function getDataApi()
    {
        // Deklarasi username dan password untuk mengakses API
        $username = 'tesprogrammer021223C16';
        $password = 'bisacoding-02-12-23';

        // Membuat objek baru dengan nama $client untuk mengakses API
        $client = new Client();

        // Melakukan request ke API dengan method POST
        $response = $client->request('POST', 'https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'form_params' => [
                'username' => $username,
                'password' => md5($password)
            ],
            'verify' => false,
        ]);

        // Mengubah bentuk data dari API menjadi array
        $result = json_decode($response->getBody()->getContents(), TRUE);

        // Menampilkan data dari API
        // header("Content-Type: application/json");
        // print_r(json_encode($result['data']));
        // exit();

        // Menyimpan data yang didapat dari API ke dalam database
        foreach ($result['data'] as $produkData) {
            $this->insertKategori($produkData['kategori']);
            $this->insertStatus($produkData['status']);
            $this->insertProduk($produkData);
        }

        // Mengembalikan data dari API yang ada di dalam array asosiatif data
        return $result['data'];
    }

    /**
     * Menyimpan data kategori ke dalam database jika belum ada
     * @param string $namaKategori nama kategori di tabel kategori
     */
    public function insertKategori($namaKategori)
    {
        // Mengecek apakah data sudah ada atau belum di dalam tabel kategori
        $query = $this->db->get_where('kategori', ['nama_kategori' => $namaKategori]);
        $result = $query->row();

        // Menyimpan data kategori ke dalam tabel kategori
        if (!$result) {
            $this->db->insert('kategori', ['nama_kategori' => $namaKategori]);
        }
    }

    /**
     * Menyimpan data status ke dalam database jika belum ada
     * @param string $namaStatus nama status di tabel status
     */
    public function insertStatus($namaStatus)
    {
        // Mengecek apakah data status sudah ada atau belum di dalam tabel status
        $query = $this->db->get_where('status', ['nama_status' => $namaStatus]);
        $result = $query->row();

        // Menyimpan data status ke dalam tabel status
        if (!$result) {
            $this->db->insert('status', ['nama_status' => $namaStatus]);
        }
    }

    /**
     * Menyimpan data produk ke dalam database
     * @param array $produkData data produk dari API
     */
    public function insertProduk($produkData)
    {
        // Mengambil id_kategori dan id_status dari tabel kategori dan tabel status
        $kategoriId = $this->getKategoriId($produkData['kategori']);
        $statusId = $this->getStatusId($produkData['status']);

        // Menyimpan data produk ke dalam tabel produk
        $this->db->insert('produk', [
            'id_produk' => $produkData['id_produk'],
            'nama_produk' => $produkData['nama_produk'],
            'harga' => $produkData['harga'],
            'kategori_id' => $kategoriId,
            'status_id' => $statusId
        ]);
    }

    /**
     * Mendapatkan id kategori berdasarkan nama kategori
     * @param string $namaKategori kolom nama_kategori di dalam tabel kategori 
     * @return int id_kategori
     */
    public function getKategoriId($namaKategori)
    {
        // Mengecek apakah data kategori sudah ada atau belum di dalam tabel kategori
        $query = $this->db->get_where('kategori', ['nama_kategori' => $namaKategori]);
        $result = $query->row();

        // Mengembalikan id_kategori untuk bisa digunakan di method insertProduk() 
        return $result->id_kategori;
    }

    /**
     * Mendapatkan ID status berdasarkan nama status
     * @param string $namaStatus nama_status di dalam tabel status
     * @return int id_status
     */
    public function getStatusId($namaStatus)
    {
        // Mengecek apakah data status sudah ada atau belum di dalam tabel status
        $query = $this->db->get_where('status', ['nama_status' => $namaStatus]);
        $result = $query->row();

        // Mengembalikan id_status untuk bisa digunakan di method insertProduk()
        return $result->id_status;
    }
}
