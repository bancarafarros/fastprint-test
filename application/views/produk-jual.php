<div class="container-fluid">

    <h1>Daftar Produk Dijual</h1>
    <br>

    <a href="<?= base_url('Produk'); ?>" class="btn btn-sm btn-primary">Daftar Produk</a>
    <br><br>

    <table class="table table-responsive table-bordered table-striped" style="margin: auto;">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Nama Produk</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Kategori ID</th>
                <th class="text-center">Status</th>
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
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
</div>