<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Produk extends CI_Controller
{
    public function index()
    {
        $this->load->model('MProduk');

        $data['produk'] = $this->MProduk->getDataProduk()->result();

        $data['title'] = 'Daftar Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('produk', $data);
        $this->load->view('/templates/footer');
    }

    public function produkJual()
    {
        $this->load->model('MProduk');

        $data['produk'] = $this->MProduk->getDataProdukJual()->result();

        $data['title'] = 'Daftar Produk Dijual';
        $this->load->view('/templates/header', $data);
        $this->load->view('produk-jual', $data);
        $this->load->view('/templates/footer', $data);
    }

    public function addProduk()
    {
        $this->load->model('MKategori');
        $this->load->model('MStatus');

        $data['kategori'] = $this->MKategori->getDataKategori()->result();
        $data['status'] = $this->MStatus->getDataStatus()->result();

        $data['title'] = 'Halaman Tambah Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('tambah-produk');
        $this->load->view('/templates/footer');
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

        $produk = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori_id,
            'status_id' => $status_id
        ];
        $this->db->insert('produk', $produk);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil disimpan</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect(base_url('Produk/produkJual'));
    }

    public function editProduk($id_produk)
    {
        $this->load->model('MProduk');
        $this->load->model('MKategori');
        $this->load->model('MStatus');

        $where = ['id_produk' => $id_produk];
        $data['produk'] = $this->MProduk->whereProduk($where, 'produk')->result();
        $data['kategori'] = $this->MKategori->getDataKategori()->result();
        $data['status'] = $this->MStatus->getDataStatus()->result();

        $data['title'] = 'Halaman Edit Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('edit-produk', $data);
        $this->load->view('/templates/footer');
    }

    public function updateProduk()
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
            redirect(base_url('Produk/produkJual'));
        }

        $id_produk = $this->input->post('id_produk');
        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $kategori_id = $this->input->post('kategori_id');
        $status_id = $this->input->post('status_id');

        $produk = [
            'id_produk' => $id_produk,
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori_id,
            'status_id' => $status_id
        ];
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk', $produk);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil diedit</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect(base_url('Produk/produkJual'));
    }

    public function deleteProduk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('produk');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil dihapus</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect(base_url('Produk/produkJual'));
    }
}
