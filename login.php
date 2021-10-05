<?php
session_start();
ob_start();
require 'functions.php';
//cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    // ambil username berdasarkan id
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    // cek cookie dan username
    if( $key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}
if ( isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}


    if( isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    
        // cek username
        if( mysqli_num_rows($result) === 1){
            // cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){
                // set sesion
                $_SESSION["login"] = true;
                // cek remember me
                if( isset($_POST['remember'])){
                    // buat cookie
                    setcookie('id', $row['id'], time()+60);
                    setcookie('key', hash('sha256',$row['username']), time()+60);
                }
                header("Location: index.php");
                exit;
            }
        }
        $error = true;
    }
ob_end_flush();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Halaman Login</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="col-md-6">
                <h1 class="text-center">Login</h1>
                <?php if( isset($error)) : ?>
                <p style="color: red; font-style: italic" class="text-center">Username/password salah!</p>
                <?php endif; ?>
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
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>   
                    <div class="form-group">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </div>   
                </form>
                <p>Belum punya akun? Klik disini untuk <a href="registrasi.php">registrasi.</a></p>
            </div>
        </div>
    </body>
</html>
