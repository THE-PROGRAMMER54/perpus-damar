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
            <p>Rafi</p>
            <span class="role">Administrator</span>
        </div>`
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
                        <th>Nama Peminjaman</th>
                        <th>Nama Buku</th>
                        <th>Jumlah Buku</th>
                        <th>Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>reihan</td>
                        <td>Matematika</td>
                        <td>13</td>
                        <td>
                            <button class="edit">edit</button>
                            <button class="delete">delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>jawa</td>
                        <td>RPL 2</td>
                        <td>13</td>
                        <td>
                            <button class="edit">edit</button>
                            <button class="delete">delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>rapi</td>
                        <td>C++</td>
                        <td>14</td>
                        <td>
                            <button class="edit">edit</button>
                            <button class="delete">delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>kurui</td>
                        <td>CI 4</td>
                        <td>14</td>
                        <td>
                            <button class="edit">edit</button>
                            <button class="delete">delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>rafael</td>
                        <td>Data Mining</td>
                        <td>14</td>
                        <td>
                            <button class="edit">edit</button>
                            <button class="delete">delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
