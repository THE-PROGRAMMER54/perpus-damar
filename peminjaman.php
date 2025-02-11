<?php 
// ambil koneksi dari koneksi.php
include "koneksi.php";

// Ambil input pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data peminjam
$query = "SELECT peminjam.*, buku.judul_buku 
          FROM peminjam 
          LEFT JOIN buku ON peminjam.id_buku = buku.id_buku";

// Tambahkan kondisi pencarian jika ada
if (!empty($search)) {
    $query .= " WHERE peminjam.nama_peminjam LIKE '%$search%' OR buku.judul_buku LIKE '%$search%'";
}

// query mysql
$data = mysqli_query($con, "$query");

// Proses pengembalian buku
if (isset($_GET['kembalikan'])) {
    $id_peminjam = $_GET['kembalikan'];

    // Update kolom update_at dengan CURRENT_TIMESTAMP
    $update_query = "UPDATE peminjam SET update_at=CURRENT_TIMESTAMP WHERE id_peminjam='$id_peminjam'";
    mysqli_query($con, $update_query);

    // Redirect untuk menghindari pengulangan pengembalian
    header("Location: peminjaman.php");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <div class="sidebar">
        <div class="profile">
            <p>Admin</p>
            <span class="role">Administrator</span>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Data Buku</a></li>
                <li><a href="peminjaman.php">Data Peminjaman</a></li>
            </ul>
        </nav>
    </div>

    <div class="content">
        <header>
            <h2>Data Peminjaman</h2>
        </header>
        <div class="fitur">
            <!-- btn tambah -->
            <a href="tambahpeminjam.php">
                <button class="btn-tambah">Pinjam</button>
            </a>
            <!-- btn search -->
            <div class="div-search">
                <form action="" method="GET">
                    <input type="text" name="search" class="search" placeholder="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">
                        <img src="./search.svg" alt="">
                    </button>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Buku</th>
                        <th>Jumlah Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Kelola</th>
                    </tr>
                </thead>
                <tbody><?php
                    $n = 1;
                    // ambil semua data dari table buku
                    $getdata = mysqli_fetch_all($data,MYSQLI_ASSOC);
                    // jika data kosong, munculkan pesan data kosong
                    if(empty($getdata)){?>
                        <tr>
                            <td colspan="6">
                                <h1 style="text-align: center;">Data Belum Ada</h1>
                            </td>
                        </tr>
                        <?php } else { 
                            // jika data ada, tampilkan data
                            foreach($getdata as $row){
                        ?>
                        <tr>
                            <td><?php echo $n++ ?></td>
                            <td><?php echo $row['nama_peminjam'] ?></td>
                            <td>
                                <?php 
                                    $querygetnamabuku ="SELECT peminjam.id_peminjam, buku.judul_buku 
                                    FROM peminjam 
                                    JOIN buku ON peminjam.id_buku = buku.id_buku";
                                    
                                    $resultgetnamabuku = mysqli_query($con, $querygetnamabuku);
                                    
                                    while($rowgetnamabuku = mysqli_fetch_assoc($resultgetnamabuku)){
                                        if($row['id_peminjam'] == $rowgetnamabuku['id_peminjam']){
                                            echo $rowgetnamabuku['judul_buku'];
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php echo $row['jumlah_buku'] ?></td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td><?php echo $row['update_at'] ?></td>
                            <td>
                            <!-- fitur Kembalikan -->
                            <?php if(is_null($row['update_at'])) { ?>
                                <a href="editbuku.php?id_buku=<?php echo $row['id_buku'] ?>" class="btn-edit">edit</a>
                                <a href="?kembalikan=<?php echo $row['id_peminjam'] ?>" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')" class="btn-kembali">Kembalikan</a>
                            <?php } else { ?>
                                <a href="deletebuku.php?id_buku=<?php echo $row['id_buku'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="btn-delete">delete</a>
                            <?php } ?>
                        </td>
                        </tr>
                        <?php 
                            }}
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
