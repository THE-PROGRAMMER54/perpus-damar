<?php
// memulai session
session_start();

// ambil koneksi dari koneksi.php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <!-- link untuk css -->
     <link rel="stylesheet" href="tambahBuku.css">
</head>
<body>
    <!-- bungkus semua isi form tambah buku -->
    <div class="container">

        <!-- buat tampilan tambah buku -->
         <form action="#" class="form" class="form" method="post">
            <div class="teks-login">
            <h1>Tambahkan Buku</h1>
            <p>isi data dibawah untuk menambahkan buku</p>
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
            <input type="text" id="judul_buku" name="judul_buku" class="input" autocomplete="off" required>
            <br>
            <label for="pengarang" class="teks-input">Pengarang Buku</label>
            <br>
            <input type="text" id="pengarang" name="pengarang" class="input" autocomplete="off" required>
            <br>
            <label for="jumlah_buku" class="teks-input">Jumlah Buku</label>
            <br>
            <input type="number" id="jumlah_buku" name="jumlah_buku" class="input" required>
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
    // query mysql
    $query_sql = "INSERT INTO buku(judul_buku,pengarang,jumlah_buku) 
                   VALUES ('$judul_buku', '$pengarang', '$jumlah_buku')";

    // menghubungkan koneksi dengan query mysql
    $result = mysqli_query($con,$query_sql);
    
    //arahkan ke dashboard jika berhasil menambah buku
    if ($result) {
        header("location: dashboard.php");
    }else {
        $_SESSION['error'] = "Gagal Menambahkan Data Silahkan Coba Lagi!!";
        header("location: tambahBuku.php");
    }
}
?>