<div class="container-fluid">

    <h1>Daftar Produk</h1>

    <table class="table table-responsive table-bordered table-striped" style="margin: auto;">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Nama Produk</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Kategori ID</th>
                <th class="text-center">Status ID</th>
            </tr>

            <?php
            $no = 1;
            foreach ($produk as $prdk) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $prdk->nama_produk; ?></td>
                    <td><?= $prdk->harga; ?></td>
                    <td><?= $prdk->kategori_id; ?></td>
                    <td><?= $prdk->status_id; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
</div>