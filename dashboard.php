<?php
// ambil koneksi dari koneksi.php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// query mysql untuk mengambil data buku dan pengurangan jumlah_buku yang ada di table buku dan dikurangi dari jumlah_buku yang ada ditable peminjam
$query = "SELECT buku.id_buku, buku.judul_buku,buku.pengarang,buku.jumlah_buku,buku.created_at,buku.update_at, /*ambil semua isi table buku */
                (buku.jumlah_buku - COALESCE(SUM(peminjam.jumlah_buku), 0)) AS sisa_buku FROM buku /* kurangi jumlah buku ditable buku dengan jumlah uku di table peminjam dan diberikan alias sisa_buku */
                LEFT JOIN peminjam ON buku.id_buku = peminjam.id_buku /* menggabungkan table pinjam dengan id buku yang ada di table buku */
                WHERE (buku.judul_buku LIKE '%$search%' OR buku.pengarang LIKE '%$search%') /*untuk pencarian*/ 
                GROUP BY buku.id_buku, buku.judul_buku, buku.jumlah_buku;"; //untuk mengelompkan data buk

// eksekusi query mysql
$data = mysqli_query($con, $query);
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
            <h2>Data Buku</h2>
        </header>

        <div class="fitur">
            <!-- btn tambah -->
            <a href="tambahbuku.php">
                <button class="btn-tambah">Tambah</button>
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

        <!-- menampilkan pesan berhasil atau gagal saat hapus data -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="pesan-sukses">
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
            <div class="pesan-error">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Buku</th>
                        <th>Pengarang</th>
                        <th>Jumlah Buku</th>
                        <th>Sisa Buku</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diupdate</th>
                        <th>Kelola</th>
                    </tr>
                </thead>

                <tbody>
                <!-- ambil data buku dari table buku -->
                 <?php
                    $n = 1;
                    // ambil semua data dari table buku
                    $getdata = mysqli_fetch_all($data,MYSQLI_ASSOC);
                    // jika data kosong, munculkan pesan data kosong
                    if(empty($getdata)){?>
                        <tr>
                            <td colspan="5">
                                <h1 style="text-align: center;">Data Belum Ada</h1>
                            </td>
                        </tr>
                        <?php } else { 
                            // jika data ada, tampilkan data
                            foreach($getdata as $row){
                        ?>
                        <tr>
                            <td><?php echo $n++ ?></td>
                            <td><?php echo $row['judul_buku'] ?></td>
                            <td><?php echo $row['pengarang'] ?></td>
                            <td><?php echo $row['jumlah_buku'] ?></td>
                            <td>
                                <?php echo $row['sisa_buku'] 
                                ?>
                            </td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td><?php echo $row['update_at'] ?></td>
                            <td>
                                <a href="editbuku.php?id_buku=<?php echo $row['id_buku'] ?>" class="btn-edit">edit</a>
                                <a href="deletebuku.php?id_buku=<?php echo $row['id_buku'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="btn-delete">delete</a>
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
