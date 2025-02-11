<?php
// memulai session
session_start();

// ambil koneksi dari koneksi.php
include "koneksi.php";

// Inisialisasi variabel
$buku = null;

// Cek apakah ada ID buku yang dikirimkan
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Query untuk mengambil data buku berdasarkan ID
    $query = "SELECT * FROM buku WHERE id_buku = '$id_buku'";
    $result = mysqli_query($con, $query);
    $buku = mysqli_fetch_assoc($result);

    // Cek apakah data buku ditemukan
    if (!$buku) {
        die("Data buku tidak ditemukan!");
    }
} else {
    die("ID buku tidak diberikan!");
}
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
            <label for="judul_buku" class="teks-input">Judul Buku</label>
            <br>
            <input type="text" id="judul_buku" name="judul_buku" class="input" value="<?php echo $buku['judul_buku']; ?>" autocomplete="off" required>
            <br>
            <label for="pengarang" class="teks-input">Pengarang Buku</label>
            <br>
            <input type="text" id="pengarang" name="pengarang" class="input" value="<?php echo $buku['pengarang']; ?>" autocomplete="off" required>
            <br>
            <label for="jumlah_buku" class="teks-input">Jumlah Buku</label>
            <br>
            <input type="number" id="jumlah_buku" name="jumlah_buku" value="<?php echo $buku['jumlah_buku']; ?>" class="input" required>
            <br>
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
    $judul_buku = $_POST["judul_buku"];
    $pengarang = $_POST["pengarang"];
    $jumlah_buku = $_POST["jumlah_buku"];
    
    // Query untuk update data buku
    $update_query = "UPDATE buku SET judul_buku='$judul_buku', pengarang='$pengarang', jumlah_buku='$jumlah_buku', update_at=NOW() WHERE id_buku='$id_buku'";

    // menghubungkan koneksi dengan query mysql
    $result = mysqli_query($con,$update_query);
    
    //arahkan ke dashboard jika berhasil mengedit buku
    if ($result) {
        header("location: dashboard.php");
    }else {
        $_SESSION['error'] = "Gagal Mengganti Data Silahkan Coba Lagi!!";
        header("location: editbuku.php?=id".$id_buku);
    }
}
?>