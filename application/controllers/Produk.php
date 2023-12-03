<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Class Produk
 * Controller untuk mengelola data produk
 */
class Produk extends CI_Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index()
    {
        // Inisiasi model MProduk
        $this->load->model('MProduk');

        // Mengambil data dari tabel produk
        $data['produk'] = $this->MProduk->getDataProduk()->result();

        // Menampilkan data produk di view 
        $data['title'] = 'Daftar Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('produk', $data);
        $this->load->view('/templates/footer');
    }

    /**
     * Menampilkan daftar produk yang dijual
     */
    public function produkJual()
    {
        // Inisiasi model MProduk
        $this->load->model('MProduk');

        // Mengambil data dari tabel produk yang memiliki status "bisa dijual"
        $data['produk'] = $this->MProduk->getDataProdukJual()->result();

        // Menampilkan data produk di view 
        $data['title'] = 'Daftar Produk Dijual';
        $this->load->view('/templates/header', $data);
        $this->load->view('produk-jual', $data);
        $this->load->view('/templates/footer', $data);
    }

    /**
     * Menampilkan halaman tambah produk
     */
    public function addProduk()
    {
        // Inisiasi model MKategori dan MStatus
        $this->load->model('MKategori');
        $this->load->model('MStatus');

        // Mengambil data dari tabel kategori dan tabel status
        $data['kategori'] = $this->MKategori->getDataKategori()->result();
        $data['status'] = $this->MStatus->getDataStatus()->result();

        // Menampilkan kategori dan status di view 
        $data['title'] = 'Halaman Tambah Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('tambah-produk');
        $this->load->view('/templates/footer');
    }

    /**
     * Menyimpan data produk baru ke database
     */
    public function insertProduk()
    {
        // Inisialisasi rules untuk form_validation
        $validation_rules = [
            // rules untuk kolom nama_produk
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                ]
            ],

            // rules untuk kolom harga
            [
                'field' => 'harga',
                'label' => 'Harga',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                    'numeric' => '<strong>%s harus diisi dengan angka saja</strong>'
                ]
            ],

            // rules untuk kolom kategori_id
            [
                'field' => 'kategori_id',
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ],

            // rules untuk kolom status_id
            [
                'field' => 'status_id',
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ]
        ];

        // Menggunakan rules yang sudah diinisialisasi di dalam form_validation
        $this->form_validation->set_rules($validation_rules);

        // Menjalankan proses validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, maka akan dikirimkan flashdata untuk setiap validasi yang gagal
            foreach ($validation_rules as $rule) {
                $field = $rule['field'];
                $error_message = form_error($field);

                // Mengirim flashdata yang berisi pesan bahwa form belum diisi dengan benar
                $this->session->set_flashdata($field, '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">' . $error_message . '</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            }

            // Mengarahkan user kembali ke halaman addProduk
            redirect(base_url('Produk/addProduk'));
        }

        // Mengambil data dari form
        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $kategori_id = $this->input->post('kategori_id');
        $status_id = $this->input->post('status_id');

        // Menampung data yang diambil dalam array
        $produk = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori_id,
            'status_id' => $status_id
        ];

        // Memasukkan data tadi ke dalam tabel produk
        $this->db->insert('produk', $produk);

        // Mengirim flashdata yang berisi pesan bahwa data berhasil disimpan
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil disimpan</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');

        // Mengarahkan user kembali ke halaman produkJual
        redirect(base_url('Produk/produkJual'));
    }

    /**
     * Menampilkan halaman edit produk
     * * @param int $id_produk ID produk yang akan diedit
     */
    public function editProduk($id_produk)
    {
        // Inisialisasi model MProduk, MKategori, dan MStatus
        $this->load->model('MProduk');
        $this->load->model('MKategori');
        $this->load->model('MStatus');

        // Mengambil data produk berdasarkan kolom id_produk
        $where = ['id_produk' => $id_produk];
        $data['produk'] = $this->MProduk->whereProduk($where, 'produk')->result();

        // Mengambil data dari tabel kategori dan tabel status
        $data['kategori'] = $this->MKategori->getDataKategori()->result();
        $data['status'] = $this->MStatus->getDataStatus()->result();

        // Menampilkan data produk, kategori, dan status di view 
        $data['title'] = 'Halaman Edit Produk';
        $this->load->view('/templates/header', $data);
        $this->load->view('edit-produk', $data);
        $this->load->view('/templates/footer');
    }

    /**
     * Mengubah data produk di database
     */
    public function updateProduk()
    {
        // Inisialisasi rules untuk form_validation
        $validation_rules = [
            // rules untuk kolom nama_produk
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                ]
            ],

            // rules untuk kolom harga
            [
                'field' => 'harga',
                'label' => 'Harga',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>',
                    'numeric' => '<strong>%s harus diisi dengan angka saja</strong>'
                ]
            ],

            // rules untuk kolom kategori_id
            [
                'field' => 'kategori_id',
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ],

            // rules untuk kolom status_id
            [
                'field' => 'status_id',
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '<strong>%s harus diisi</strong>'
                ]
            ]
        ];

        // Menggunakan rules yang sudah diinisialisasi di dalam form_validation
        $this->form_validation->set_rules($validation_rules);

        // Menjalankan proses validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, maka akan dikirimkan flashdata untuk setiap validasi yang gagal
            foreach ($validation_rules as $rule) {
                $field = $rule['field'];
                $error_message = form_error($field);

                // Mengirim flashdata yang berisi pesan bahwa form belum diisi dengan benar
                $this->session->set_flashdata($field, '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">' . $error_message . '</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            }
            // Mengarahkan user kembali ke halaman produkJual
            redirect(base_url('Produk/produkJual'));
        }

        // Mengambil data dari form
        $id_produk = $this->input->post('id_produk');
        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $kategori_id = $this->input->post('kategori_id');
        $status_id = $this->input->post('status_id');

        // Menampung data yang diambil dalam array
        $produk = [
            'id_produk' => $id_produk,
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori_id,
            'status_id' => $status_id
        ];

        // Set klausa where untuk menargetkan id_produk
        $this->db->where('id_produk', $id_produk);

        // Melakukan update data produk dari id_produk yang ditargetkan
        $this->db->update('produk', $produk);

        // Mengirim flashdata yang berisi pesan bahwa data berhasil diedit
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil diedit</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');

        // Mengarahkan user kembali ke halaman produkJual
        redirect(base_url('Produk/produkJual'));
    }

    /**
     * Menghapus data produk di database
     * @param int $id_produk ID produk yang akan dihapus
     */
    public function deleteProduk($id_produk)
    {
        // Set klausa where untuk menargetkan id_produk
        $this->db->where('id_produk', $id_produk);

        // Menghapus data produk dari tabel produk
        $this->db->delete('produk');

        // Mengirim flashdata yang berisi pesan bahwa data berhasil dihapus
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text"><strong>Data berhasil dihapus</strong></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');

        // Mengarahkan user kembali ke halaman produkJual
        redirect(base_url('Produk/produkJual'));
    }
}
