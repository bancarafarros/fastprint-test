<div class="container-fluid">

    <h1>Daftar Produk Dijual</h1>
    <br>

    <?= $this->session->flashdata('message'); ?>
    <?= $this->session->flashdata('nama_produk'); ?>
    <?= $this->session->flashdata('harga'); ?>
    <?= $this->session->flashdata('kategori_id'); ?>
    <?= $this->session->flashdata('status_id'); ?>

    <div class="row">
        <div class="col-md-6">
            <a href="<?= base_url('Produk/addProduk'); ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= base_url('Produk'); ?>" class="btn btn-sm btn-primary">Daftar Produk</a>
        </div>
    </div>
    <br>

    <table class="table table-responsive table-bordered table-striped" style="margin: auto;">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Nama Produk</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Kategori ID</th>
                <th class="text-center">Status</th>
                <th class="text-center" colspan="2">Aksi</th>
            </tr>

            <?php
            $no = 1;
            foreach ($produk as $prdk) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $prdk->nama_produk; ?></td>
                    <td>Rp <?= number_format($prdk->harga, 0, ',', '.'); ?></td>
                    <td><?= $prdk->kategori_id; ?></td>
                    <td><?= $prdk->status_id == 1 ? 'bisa dijual' : 'tidak bisa dijual'; ?></td>
                    <td>
                        <?= anchor(
                            'Produk/editProduk/' . $prdk->id_produk,
                            '<div class="btn btn-warning btn-sm"><i class="fa-solid fa-edit"></i></div>'
                        ) ?>
                    </td>
                    <td>
                        <?= anchor(
                            'Produk/deleteProduk/' . $prdk->id_produk,
                            '<div class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></div>'
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
</div>