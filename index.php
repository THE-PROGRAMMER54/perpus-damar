<?php
// memulai session agar bisa menggunakan $_session
session_start();

// ngambil $con dari koneksi.php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- link untuk css -->
     <link rel="stylesheet" href="login.css">
</head>
<body>
    <!-- bungkus semua isi login -->
    <div class="container">

        <!-- buat tampilan login -->
         <form action="#" class="form" class="form" method="post">
            <div class="teks-login">
            <h1>Login</h1>
            <p>kaitkan akun untuk masuk</p>
            </div>

            <!-- untuk menampilkan pesan error jika login gagal -->
             <?php if(isset($_SESSION['error'])) {?>
                <div class="pesan-error">
                    <?php
                        // munculin pesan error
                        echo $_SESSION['error'];

                        // Hapus error setelah ditampilkan
                        unset($_SESSION['error']);
                    ?>
                </div>
             <?php }?>

            <!-- untuk form input -->
             <div class="form-input">
            <label for="username" class="teks-input">USERNAME</label>
            <br>
            <input type="text" id="username" name="username" class="input" required>
            <br>
            <label for="password" class="teks-input">PASSWORD</label>
            <br>
            <input type="password" id="password" name="password" class="input" required>
            <br>
            <input class="login" type="submit" name="login" value="Login">
             </div>
         </form>
    </div>
</body>
</html>

<?php
// cek apakah inputan dengan name login ditekan
if(isset($_POST['login'])){
    // ambil inputan username dan password
    $username = $_POST["username"];
    $password = $_POST["password"];
    // query mysql
    $query_sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    // menghubungkan koneksi dengan query mysql
    $result = mysqli_query($con,$query_sql);
    
    //cek apakah login berhasil atau tidak 
    if (mysqli_num_rows($result) > 0) {
        header("location:dashboard.php");
    }else {
        // jika gagal, tampilkan pesan error dan kembali ke halaman login
        $_SESSION['error'] = "username atau password anda salah !!";
        header("location:index.php");
    }
}
?>