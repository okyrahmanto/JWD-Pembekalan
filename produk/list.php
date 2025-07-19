<html>
<head>
    <title>Produk List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/csslist.css">
</head>
<body>
    <div class="container">
        <?php
            require 'config/dbloader.php';
            $products = $productManager->loadProducts();
            $stats = $productManager->getProductStats();
        ?>
        <h1>Daftar Produk</h1>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk</h5>
                        <p class="card-text h3"><?= $stats['total'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Stok</h5>
                        <p class="card-text h3"><?= $stats['total_stock'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Total Nilai</h5>
                        <p class="card-text h3">Rp <?= number_format($stats['total_value'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Kategori</h5>
                        <p class="card-text h3"><?= count($stats['categories']) ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
        <a href="chart" class="btn btn-success btn-sm">Grafik</a>
        
        <table class="table table-striped">
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
            <?php
            foreach ($products as $product) {
                $totalValue = $product['price'] * $product['stock'];
                echo "<tr>";
                echo "<td>{$product['name']}</td>";
                echo "<td>{$product['category']}</td>";
                echo "<td>Rp " . number_format($product['price'], 0, ',', '.') . "</td>";
                echo "<td>{$product['stock']}</td>";
                echo "<td>Rp " . number_format($totalValue, 0, ',', '.') . "</td>";
                echo '<td>';
                echo '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal"';
                echo ' onclick=\'editProduct(' . json_encode($product, JSON_HEX_APOS | JSON_HEX_QUOT) . ')\'';
                echo '>Edit</button>';
                echo '</td>';
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <!-- Loading spinner -->
    <div id="loading" class="loading">
        <div class="spinner"></div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="add">
                <div class="modal-header"><h5 class="modal-title">Form Create Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>Nama</label>
                    <input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label>Kategori</label>
                    <input type="text" name="category" class="form-control" required></div>
                    <div class="mb-3"><label>Harga</label>
                    <input type="number" name="price" class="form-control" required></div>
                    <div class="mb-3"><label>Stok</label>
                    <input type="number" name="stock" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="updateModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="update">
                <div class="modal-header"><h5 class="modal-title">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3"><label>Nama</label><input type="text" name="name" id="edit-name" class="form-control" required></div>
                    <div class="mb-3"><label>Kategori</label><input type="text" name="category" id="edit-category" class="form-control" required></div>
                    <div class="mb-3"><label>Harga</label><input type="number" name="price" id="edit-price" class="form-control" required></div>
                    <div class="mb-3"><label>Stok</label><input type="number" name="stock" id="edit-stock" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/scriptlist.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body> 
</html>


