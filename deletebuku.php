<?php
// memulai session
session_start();

// ambil koneksi dari koneksi.php
include "koneksi.php";

// Cek apakah ada ID buku yang dikirimkan
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Query untuk menghapus data buku
    $delete_query = "DELETE FROM buku WHERE id_buku = '$id_buku'";

    if (mysqli_query($con, $delete_query)) {
        $_SESSION['success'] = "Buku berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus buku: " . mysqli_error($con);
    }
} else {
    $_SESSION['error'] = "ID buku tidak diberikan!";
}

// Redirect kembali ke halaman dashboard
header("Location: dashboard.php");
?>