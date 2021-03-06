<?php

  session_start();
  require('../config/config.php');
  require('../config/common.php');
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
  }
  if($_SESSION['role']!=1){
    header('Location:login.php');
  }
  //print_r($_SESSION);
  if($_POST){
    if(empty($_POST['name']) || empty($_POST['email'])){
     
      if(empty($_POST['name'])){
        $nameError="Name cannot be null.";
      }
      if(empty($_POST['email'])){
        $emailError="Email cannot be null.";
      }
      
    }elseif( !empty($_POST['password']) && strlen($_POST['password']) < 4){
      $passwordError = 'Password should be 4 characters at least';
    }
    else{
      $id=$_POST['id'];
      $name=$_POST['name'];
      $email=$_POST['email'];
      $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
      $role=(!empty($_POST['role'])?1:0);
    // echo $role;
    // exit();
      $statement=$db->prepare('SELECT * FROM users WHERE email=:email AND id!=:id');
      $statement->execute([
          ':email' => $email,
          ':id'   => $id,
      ]);
      $resultusers=$statement->fetch(PDO::FETCH_ASSOC);
    
        if($resultusers){
            echo "<script>alert('Already created account with this email!')</script>";
        }else{
          if($password==null){
            $stmt=$db->prepare("UPDATE users SET name=:name,email=:email,role=:role WHERE id=:id");
            $result=$stmt->execute([
                ':name'=>$name,
                ':email'=>$email,
                ':role'=>$role,
                ':id'=>$id,
            ]);
          }else{
              $stmt=$db->prepare("UPDATE users SET name=:name,email=:email,password=:password,role=:role WHERE id=:id");
              $result=$stmt->execute([
                  ':name'=>$name,
                  ':email'=>$email,
                  ':password'=>$password,
                  ':role'=>$role,
                  ':id'=>$id,
              ]);
            }
              if($result){
                  echo "<script>alert('Successfully User Updated!');window.location.href='userindex.php';</script>";
              }
          

        }
    }   
  }
$userID=$_GET['id'];
$stmt=$db->prepare("SELECT * FROM users WHERE id=$userID");
$stmt->execute();
$result=$stmt->fetch();

?>

<?php include('header.php'); ?>

  <!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form action="" method="post">
            <input name="_token" type="hidden"  value="<?php echo $_SESSION['_token']; ?>">
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">User Name:</label>
                    <input type="text" name="name" id="name" class="form-control <?php echo empty($nameError) ? '':'is-invalid'; ?>" value="<?php echo escape($result['name']); ?>" >
                    <div class="invalid-feedback">
                        <?php echo empty($nameError) ? '': $nameError; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Enter Email:</label>
                    <input type="email" class="form-control <?php echo empty($emailError) ? '':'is-invalid'; ?>" name="email" id="email" value="<?php echo escape($result['email']); ?>" >
                    <div class="invalid-feedback">
                        <?php echo empty($emailError) ? '': $emailError; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Enter Password:</label>
                    <input type="password" class="form-control  <?php echo empty($passwordError) ? '':'is-invalid'; ?>" name="password" id="password">
                    <small id="emailHelp" class="form-text text-muted">The user already has a password.</small>
                    <div class="invalid-feedback">
                        <?php echo empty($passwordError) ? '': $passwordError; ?>
                    </div>
                </div>
                <div class="form-check mb-5">
                    <input class="form-check-input" type="checkbox" value="1" id="role" name="role" <?php echo (escape($result['role'])==1?'checked':''); ?>>
                    <label class="form-check-label" for="role">
                        <b>Role</b>
                    </label>
                </div>
                <input type="submit" value="Edit" class="btn btn-success">
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
