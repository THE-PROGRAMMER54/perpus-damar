<?php
// memulai session
session_start();

// ambil koneksi dari koneksi.php
include "koneksi.php";

// Inisialisasi variabel
$peminjam = null;

// Cek apakah ada ID peminjam yang dikirimkan
if (isset($_GET['id_peminjam'])) {
    $id_peminjam = $_GET['id_peminjam'];

    // Query untuk mengambil data peminjam berdasarkan ID
    $query = "SELECT * FROM peminjam WHERE id_peminjam = '$id_peminjam'";
    $result = mysqli_query($con, $query);
    $peminjam = mysqli_fetch_assoc($result);

    // Cek apakah data peminjam ditemukan
    if (!$peminjam) {
        die("Data peminjam tidak ditemukan!");
    }
} else {
    die("ID peminjam tidak diberikan!");
}

// Ambil data buku untuk ganti nama buku
$query_buku = "SELECT * FROM buku";
$result_buku = mysqli_query($con, $query_buku);
$data_buku = mysqli_fetch_assoc($result_buku);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit Buku</title>
    <!-- link untuk css -->
     <link rel="stylesheet" href="tambahBuku.css">
</head>
<body>
    <!-- bungkus semua isi form edit buku -->
    <div class="container">

        <!-- buat tampilan edit buku -->
         <form action="#" class="form" class="form" method="post">
            <div class="teks-login">
            <h1>Edit Buku</h1>
            <p>isi data dibawah untuk mengedit buku</p>
            </div>

            <!-- pesan error jika data gagal disimpan -->
             <?php if(isset($_SESSION['error'])) {?>
                <div class="pesan-error">
                    <?php
                        // munculin pesan error
                        echo $_SESSION['error'];
                        // hapus pesan error setelah ditampilkan
                        unset($_SESSION['error']);
                   ?>
                </div>
            <?php }?>

            <!-- untuk form input -->
             <div class="form-input">
             <label for="nama_peminjam">Nama Peminjam</label>
            <input type="text" id="nama_peminjam" name="nama_peminjam" class="input" value="<?php echo $peminjam['nama_peminjam']; ?>" required>
            <br>
            <label for="id_buku">Pilih Buku</label>
            <select id="id_buku" name="id_buku" required class="input">
                <option value="">-- Pilih Buku --</option>
                <?php while ($row_buku = mysqli_fetch_assoc($result_buku)) { ?>
                    <option value="<?php echo $row_buku['id_buku']; ?>" <?php echo ($row_buku['id_buku'] == $peminjam['id_buku']) ? 'selected' : ''; ?>>
                        <?php echo $row_buku['judul_buku']; ?>
                    </option>
                <?php } ?>
            </select>
            <br>
            <label for="jumlah_buku">Jumlah Buku</label>
            <input type="number" id="jumlah_buku" name="jumlah_buku" value="<?php echo $peminjam['jumlah_buku']; ?>" required class="input">

            <input class="tambah" type="submit" name="tambah" value="tambah">
             </div>
         </form>
    </div>
</body>
</html>

<?php
// cek apakah inputan dengan name login ditekan
if(isset($_POST['tambah'])){
    // ambil inputan dari user
    $nama_peminjam = $_POST['nama_peminjam'];
    $id_buku = $_POST['id_buku']; // ID buku yang dipilih
    $jumlah_buku = $_POST['jumlah_buku'];
    
    // Cek apakah jumlah buku yang dipinjam tidak melebihi jumlah buku yang tersedia
    if ($jumlah_buku > $data_buku['jumlah_buku']) {
        $_SESSION['error'] = "Jumlah buku yang tersedia hanya ".$data_buku['jumlah_buku'];
        header("Location: editpinjam.php?id_peminjam=".$id_peminjam);
    }else{

    // Query untuk update data peminjam
    $update_query = "UPDATE peminjam SET nama_peminjam='$nama_peminjam', id_buku='$id_buku', jumlah_buku='$jumlah_buku', update_at=NOW() WHERE id_peminjam='$id_peminjam'";

    // menghubungkan koneksi dengan query mysql
    $result = mysqli_query($con,$update_query);
    
    //arahkan ke dashboard jika berhasil mengedit buku
    if ($result) {
        header("location: peminjaman.php");
    }else {
        $_SESSION['error'] = "Gagal Mengganti Data Silahkan Coba Lagi!!";
        header("location: editpinjam.php?=id".$id_buku);
    }
}
}
?>