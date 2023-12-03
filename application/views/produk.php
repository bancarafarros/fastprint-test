<div class="container-fluid">

    <h1>Daftar Produk</h1>
    <br>

    <a href="<?= base_url('Produk/produkJual'); ?>" class="btn btn-sm btn-primary">Daftar Produk Dijual</a>
    <br><br>

    <table class="table table-responsive table-bordered table-striped" style="margin: auto;">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Nama Produk</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Kategori ID</th>
                <th class="text-center">Status ID</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            foreach ($produk as $prdk) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $prdk->nama_produk; ?></td>
                    <td>Rp <?= number_format($prdk->harga, 0, ',', '.'); ?></td>
                    <td><?= $prdk->kategori_id; ?></td>
                    <td><?= $prdk->status_id; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>