<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Test extends CI_Controller
{
    public function index()
    {
        $this->load->model('MProduk');
        $data['produk'] = $this->MProduk->getDataProduk()->result();

        $this->load->view('/templates/header', $data);
        $this->load->view('produk', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function getDataApi()
    {
        $username = 'tesprogrammer021223C13';
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

        // Insert data into Kategori and Status tables (assuming they don't exist yet)
        foreach ($result['data'] as $produkData) {
            $this->insertKategori($produkData['kategori']);
            $this->insertStatus($produkData['status']);
        }

        // Insert data into Produk table
        foreach ($result['data'] as $produkData) {
            $this->insertProduk($produkData);
        }

        return $result['data'];
    }

    public function insertKategori($namaKategori)
    {
        // Check if the category already exists
        $query = $this->db->get_where('kategori', ['nama_kategori' => $namaKategori]);
        $result = $query->row();

        if (!$result) {
            // Insert the category
            $this->db->insert('kategori', ['nama_kategori' => $namaKategori]);
        }
    }

    public function insertStatus($namaStatus)
    {
        // Check if the status already exists
        $query = $this->db->get_where('status', ['nama_status' => $namaStatus]);
        $result = $query->row();

        if (!$result) {
            // Insert the status
            $this->db->insert('status', ['nama_status' => $namaStatus]);
        }
    }

    public function insertProduk($produkData)
    {
        // Get Kategori and Status IDs
        $kategoriId = $this->getKategoriId($produkData['kategori']);
        $statusId = $this->getStatusId($produkData['status']);

        // Insert Produk data
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

    public function insertProduk()
    {
        $validation_rules = [
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                ]
            ],
            [
                'field' => 'harga',
                'label' => 'Harga',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                    'numeric' => '<strong>%s harus diisi dengan angka saja</strong>'
                ]
            ],
            [
                'field' => 'kategori_id',
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ],
            [
                'field' => 'status_id',
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ]
        ];

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() == FALSE) {
            foreach ($validation_rules as $rule) {
                $field = $rule['field'];
                $error_message = form_error($field);

                $this->session->set_flashdata($field, '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">' . $error_message . '</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            }
            redirect(base_url('Produk/addProduk'));
        }

        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $kategori_id = $this->input->post('kategori_id');
        $status_id = $this->input->post('status_id');

        $arrInsert = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori_id,
            'status_id' => $status_id
        ];
        $this->db->insert('produk', $arrInsert);
        redirect(base_url('Produk'));
    }
}
