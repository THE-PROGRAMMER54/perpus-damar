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
    <title>Tambah Peminjam</title>
    <!-- link untuk css -->
     <link rel="stylesheet" href="tambahBuku.css">
</head>
<body>
    <!-- bungkus semua isi form tambah peminjam -->
    <div class="container">

        <!-- buat tampilan tambah peminjam -->
         <form action="#" class="form" class="form" method="post">
            <div class="teks-login">
            <h1>Tambahkan Peminjam</h1>
            <p>isi data dibawah untuk menambahkan peminjaman</p>
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
            <label for="nama_peminjam" class="teks-input">Nama Peminjam</label>
            <br>
            <input type="text" id="nama_peminjam" name="nama_peminjam" class="input" required>
            <br>
            <label for="id_buku" class="teks-input">Judul Buku</label>
            <br>
            <select id="id_buku" name="id_buku" class="input" required>
                <option value="">-- Pilih Buku --</option>
                <!-- munculkan data buku yang ada di table buku -->
                <?php
                    $query = "SELECT * FROM buku";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id_buku']."'>".$row['judul_buku']."</option>";
                    }
                ?>
            </select>
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
    $nama_peminjam = $_POST["nama_peminjam"];
    $id_buku = $_POST["id_buku"];
    $jumlah_buku = $_POST["jumlah_buku"];
    // query mysql
    $query_sql = "INSERT INTO peminjam(nama_peminjam,id_buku,jumlah_buku) 
                   VALUES ('$nama_peminjam', '$id_buku', '$jumlah_buku')";

    // menghubungkan koneksi dengan query mysql
    $result = mysqli_query($con,$query_sql);
    
    //arahkan ke dashboard jika berhasil menambah buku
    if ($result) {
        header("location: dashboard.php");
    }else {
        $_SESSION['error'] = "Gagal Menambahkan Data Silahkan Coba Lagi!!";
        header("location: tambahpeminjam.php");
    }
}
?>