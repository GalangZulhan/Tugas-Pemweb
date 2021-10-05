<?php
require 'functions.php';

if( isset($_POST["register"])){
    if( registrasi($_POST) > 0){
        echo "<script>
                alert('User baru berhasil ditambahkan!');
             </script>";
    } else {
        echo mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Registrasi</title>
        <style>
            label{
                display: block;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
    <div class="col-md-6">
        <h1 class="text-center">Registrasi</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>  
            <div class="form-group">
                <label for="password2">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2" class="form-control" required>    
            </div>   
            <div class="form-group">
                <button type="submit" name="register" class="btn btn-primary">Register</button>
            </div>   
        </form>
        <p>Belum punya akun? Klik disini untuk <a href="login.php">login.</a></p>
        </div>
        </div>
    </body>
</html>