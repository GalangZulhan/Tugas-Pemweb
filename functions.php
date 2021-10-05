<?php
 //Koneksi database
 $server = "localhost";
 $user = "root";
 $pass = "";
 $database = "dblatihan";

 $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

 //Jika tombol simpan diklik
 if(isset($_POST['bsimpan'])){
     //Pengujian apakah data akan diedit atau disimpan
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
function registrasi($data){
    global $koneksi;
    
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
    if( mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Username sudah terdaftar!');
             </script>"; 
        return false;
    }
    // cek konfirmasi password
    if( $password !== $password2 ){
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // tambahkan userbaru ke database
    mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($koneksi);
}
?>