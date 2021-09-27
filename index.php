<?php
    //Koneksi database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //Jika tombol simpan diklik
    if(isset($_POST['bsimpan'])){
        //Pengujian apakah data akan dietit atau disimpan
        if($_GET['hal'] == "edit"){
            //Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE tmhs set
                                                nama = '$_POST[tnama]',
                                                nim = '$_POST[tnim]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                              WHERE id_mhs = '$_GET[id]'
                                            ");
            if($edit){
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else{
                echo "<script>
                        alert('Edit data gagal.');
                        document.location='index.php';
                    </script>";
            }
        } 
        else{
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nama, nim, alamat, prodi)
                                          VALUES ('$_POST[tnama]', '$_POST[tnim]',
                                          '$_POST[talamat]', '$_POST[tprodi]')");
            if($simpan){
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else{
                echo "<script>
                        alert('Simpan data gagal.');
                        document.location='index.php';
                    </script>";
            }
        }  
    }

    //Jika tombol Edit/Hapus Diklik
    if(isset($_GET['hal'])){
        //Jika data akan diedit
        if($_GET['hal'] == "edit"){
            //Tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data){
                //Jika daat ditemukan, maka data ditampung ke dalam variabel terlebih dahulu
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if($_GET['hal'] == "hapus"){
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]'");
            if($hapus){
                echo "<script>
                        alert('Hapus data sukses!');
                        document.location='index.php';
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2020 PHP & MySQL</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <h1 class="text-center">CRUD PHP & MySQL</h1>
    <h4 class="text-center">Galang Zulhan D./205150207111013</h4>

    <!-- Awal Card Form -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Form Input Data Mahasiswa
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="tnama" value="<?=@$vnama?>" id="nama" class="form-control" placeholder="Input nama anda..." required>
                </div>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" name="tnim" value="<?=@$vnim?>" id="nim" class="form-control" placeholder="Input NIM anda..." required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="talamat" id="alamat" placeholder="Input alamat anda..."><?=@$valamat?></textarea>
                </div>
                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <select class="form-control" name="tprodi" id="program-studi">
                        <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                        <option value="TIF">TIF</option>
                        <option value="SI">SI</option>
                        <option value="TI">TI</option>
                        <option value="TEKKOM">TEKKOM</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
            </form>
        </div>
    </div>
    <!-- Akhir Card Form -->

    <!-- Awal Card Table -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            Daftar Mahasiswa
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Alamat</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                    while($data = mysqli_fetch_array($tampil)):
                ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$data['nama']?></td>
                    <td><?=$data['nim']?></td>
                    <td><?=$data['alamat']?></td>
                    <td><?=$data['prodi']?></td>
                    <td>
                        <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm
                        ('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <!-- Akhir Card Table -->

    </div>
<script type="text/javascript" src="js/bootstrap.min.css"></script>
</body>
</html>