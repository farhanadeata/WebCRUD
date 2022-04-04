<?php
session_start();
// Jika bisa login maka ke index.php
if (isset($_SESSION['login'])) {
    header('location:index.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// jika tombol yang bernama login diklik
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    // password menggunakan md5

    // mengambil data dari user dimana username yg diambil
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    $cek = mysqli_num_rows($result);

    // jika $cek lebih dari 0, maka berhasil login dan masuk ke index.php
    if ($cek > 0) {
        $_SESSION['login'] = true;

        // cek remember me
        if (isset($_POST['remember'])) {
            // buat cookie dan acak cookie

            setcookie('id', $row['id'], time() + 60);

            // mengacak $row dengan algoritma 'sha256'
            setcookie('key', hash('sha256', $row['username']), time() + 60);
        }

        header('location:index.php');
        exit;
    }
    // jika $cek adalah 0 maka tampilkan error
    $error = true;  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
     <!-- Font Google -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
     <!-- My CSS -->
     <link rel="stylesheet" href="css/login.css">

     <title>From Login</title>
</head>

<body background="img/bg/bck.png">

     <div class="container">
          <div class="row my-5">
               <div class="col-md-6 text-center login bg-dark">
                    <h4 class="fw-bold" style="color: white;">Login Dulu Banh:)</h4>
                    <!-- Ini Error jika tidak bisa login -->
                    <?php if (isset($error)) : ?>
                    <?php echo '<script>alert("Username atau Password Salah!");</script>'; ?>
                    <?php endif; ?>
                    <form action="" method="post">
                         <div class="form-group user">
                              <input type="text" class="form-control w-50" placeholder="Masukkan Username"
                                   name="username" autocomplete="off" required>
                         </div>
                         <div class="form-group my-5">
                              <input type="password" class="form-control w-50" placeholder="Masukkan Password"
                                   name="password" autocomplete="off" required>
                         </div>
                         <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                              <input type="checkbox" class="btn-check" name="remember" id="remember" autocomplete="off">
                              <label class="btn btn-outline-primary" for="remember">Remember Me</label>

                         </div>
                         <button class="btn btn-primary text-uppercase" type="submit" name="login">Login</button>
                         <a href="registrasi.php" class="btn btn-danger text-uppercase"><i
                                   class="bi bi-pencil-square"></i>SIGN UP</a> |

                    </form>
               </div>
          </div>
     </div>



     <!-- Bootstrap -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
     </script>
</body>

</html>