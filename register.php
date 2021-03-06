<?php
session_start();
require('config/config.php');
require('config/common.php');
    if($_POST){
      if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pwd']) ||  strlen($_POST['pwd']) < 4){
     
        if(empty($_POST['name'])){
          $nameError="Name cannot be null.";
        }
        if(empty($_POST['email'])){
          $emailError="Email cannot be null.";
        }
        if(empty($_POST['pwd'])){
          $passwordError="Password cannot be null";
        }
        if(strlen($_POST['pwd']) < 4){
          $passwordError = 'Password should be 4 characters at least';
        } 
      }else{
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=password_hash($_POST['pwd'],PASSWORD_DEFAULT);

        $statement=$db->prepare('SELECT * FROM users WHERE email=:email');
        $statement->bindValue(':email',$email);
        $statement->execute();

        $user=$statement->fetch(PDO::FETCH_ASSOC);
        if($user){
            echo "<script>alert('Already created account with this email!')</script>";
        }else{
            
            $stmt=$db->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
            $result=$stmt->execute([
              ':name'=>$name,
              ':email'=>$email,
              ':password'=>$password,
              ':role'=>0,
            ]);
            if($result){
                echo "<script>alert('Successfully Register.You can now login!');window.location.href='login.php';</script>";
            }
        }

      }
        
    }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="login.php" class="h1"><b>Blog</b></a>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New Account</p>

      <form action="register.php" method="post">
      <input name="_token" type="hidden"  value="<?php echo $_SESSION['_token']; ?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control  <?php echo empty($nameError) ? '':'is-invalid'; ?>" placeholder="Username" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <div class="invalid-feedback">
            <?php echo empty($nameError) ? '': $nameError; ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control  <?php echo empty($emailError) ? '':'is-invalid'; ?>" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <div class="invalid-feedback">
            <?php echo empty($emailError) ? '': $emailError; ?>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control  <?php echo empty($passwordError) ? '':'is-invalid'; ?>" placeholder="Password" name="pwd">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="invalid-feedback">
            <?php echo empty($passwordError) ? '': $passwordError; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <a href="login.php" class="btn btn-default btn-block">Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
