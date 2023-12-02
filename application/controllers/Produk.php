<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Produk extends CI_Controller
{
    public function index()
    {
        $this->load->model('MProduk');
        $data['title'] = 'Daftar Produk';
        $data['produk'] = $this->MProduk->getDataProduk()->result();

        $this->load->view('/templates/header', $data);
        $this->load->view('produk', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function produkJual()
    {
        $this->load->model('MProduk');
        $data['title'] = 'Daftar Produk Dijual';
        $data['produk'] = $this->MProduk->getDataProdukJual()->result();

        $this->load->view('/templates/header', $data);
        $this->load->view('produk-jual', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function getDataApi()
    {
        $username = 'tesprogrammer021223C16';
        $password = 'bisacoding-02-12-23';
        $client = new Client();

        $response = $client->request('POST', 'https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'form_params' => [
                'username' => $username,
                'password' => md5($password)
            ],
            'verify' => false,
        ]);

        $result = json_decode($response->getBody()->getContents(), TRUE);

        // header("Content-Type: application/json");
        // print_r(json_encode($result['data']));
        // exit();

        foreach ($result['data'] as $produkData) {
            $this->insertKategori($produkData['kategori']);
            $this->insertStatus($produkData['status']);
            $this->insertProduk($produkData);
        }

        return $result['data'];
    }

    public function insertKategori($namaKategori)
    {
        $query = $this->db->get_where('kategori', ['nama_kategori' => $namaKategori]);
        $result = $query->row();

        if (!$result) {
            $this->db->insert('kategori', ['nama_kategori' => $namaKategori]);
        }
    }

    public function insertStatus($namaStatus)
    {
        $query = $this->db->get_where('status', ['nama_status' => $namaStatus]);
        $result = $query->row();

        if (!$result) {
            $this->db->insert('status', ['nama_status' => $namaStatus]);
        }
    }

    public function insertProduk($produkData)
    {
        $kategoriId = $this->getKategoriId($produkData['kategori']);
        $statusId = $this->getStatusId($produkData['status']);

        $this->db->insert('produk', [
            'id_produk' => $produkData['id_produk'],
            'nama_produk' => $produkData['nama_produk'],
            'harga' => $produkData['harga'],
            'kategori_id' => $kategoriId,
            'status_id' => $statusId
        ]);
    }

    public function getKategoriId($namaKategori)
    {
        $query = $this->db->get_where('kategori', ['nama_kategori' => $namaKategori]);
        $result = $query->row();

        return $result->id_kategori;
    }

    public function getStatusId($namaStatus)
    {
        $query = $this->db->get_where('status', ['nama_status' => $namaStatus]);
        $result = $query->row();

        return $result->id_status;
    }
}
