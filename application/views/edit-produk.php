<div class="container-fluid">

    <h1>Halaman Edit Produk</h1>
    <br>

    <?= $this->session->flashdata('nama_produk'); ?>
    <?= $this->session->flashdata('harga'); ?>
    <?= $this->session->flashdata('kategori_id'); ?>
    <?= $this->session->flashdata('status_id'); ?>

    <?php foreach ($produk as $prdk) : ?>
        <form action="<?= base_url('Produk/updateProduk') ?>" method="post">
            <input type="hidden" name="id_produk" class="form-control" value="<?= $prdk->id_produk; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= $prdk->nama_produk; ?>" required>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= $prdk->harga; ?>" required>
                    </div>
                    <br>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Kategori</label>
                        <div class="form-group">
                            <select class="form-select" name="kategori_id" required>
                                <option value="">Pilih kategori</option>
                                <?php foreach ($kategori as $ktg) : ?>
                                    <option value="<?= $ktg->id_kategori; ?>"><?= $ktg->nama_kategori; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <label for="name">Status</label>
                        <div class="form-group">
                            <select class="form-select" name="status_id" required>
                                <option value="">Pilih status</option>
                                <?php foreach ($status as $sts) : ?>
                                    <option value="<?= $sts->id_status ?>"><?= $sts->nama_status ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <br>
                </div>
            </div>

            <a href="<?= base_url('Produk/produkJual'); ?>" class="btn btn-danger">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    <?php endforeach; ?>
</div>