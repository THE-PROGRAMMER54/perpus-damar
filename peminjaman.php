<?php 
// ambil koneksi dari koneksi.php
include "koneksi.php";

// query mysql
$data = mysqli_query($con, "SELECT * FROM peminjam");

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
            <a href="tambahpeminjam.php">
                <button class="btn-tambah">Pinjam</button>
            </a>
            <div class="div-search">
                <input type="text" name="search" class="search" placeholder="search">
                <img src="./search.svg" alt="">
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
                            <td><?php echo $row['update_at'] ?></td>
                            <td>
                                <a href="editpinjam.php?id_peminjam=<?php echo $row['id_peminjam'] ?>" class="btn-edit">edit</a>
                                <a href="" class="btn-delete">delete</a>
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
