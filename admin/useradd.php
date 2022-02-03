<?php
require('../config/config.php');
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
  }
  if($_SESSION['role']!=1){
    header('Location:login.php');
  }
  //print_r($_SESSION);
  if($_POST){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role=(!empty($_POST['role'])?1:0);
    // echo $role;
    // exit();
    $statement=$db->prepare('SELECT * FROM users WHERE email=:email');
    $statement->bindValue(':email',$email);
    $statement->execute();
    $resultusers=$statement->fetch(PDO::FETCH_ASSOC);

    if($resultusers){
        echo "<script>alert('Already created account with this email!')</script>";
    }else{
        $stmt=$db->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
        $result=$stmt->execute([
            ':name'=>$name,
            ':email'=>$email,
            ':password'=>$password,
            ':role'=>$role,
        ]);
        if($result){
            echo "<script>alert('Successfully New User Added!');window.location.href='userindex.php';</script>";
        }
    }
  }
?>

<?php include('header.php'); ?>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form action="useradd.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">User Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Enter Email:</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Enter Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-check mb-5">
                    <input class="form-check-input" type="checkbox" value="1" id="role" name="role">
                    <label class="form-label" for="role">
                        <b>Admin</b>
                    </label>
                </div>
                <input type="submit" value="Add" class="btn btn-warning">
                <a href="userindex.php" class="btn btn-secondary">Back</a>
            </form>
          </div>
          <!-- /.card-body -->
          
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<?php include('footer.html'); ?>
