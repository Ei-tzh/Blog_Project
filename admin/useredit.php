<?php
require('../config/config.php');
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
  }
  //print_r($_SESSION);
  if($_POST){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
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
            $stmt=$db->prepare("UPDATE users SET name=:name,email=:email,password=:password,role=:role WHERE id=:id");
            $result=$stmt->execute([
                ':name'=>$name,
                ':email'=>$email,
                ':password'=>$password,
                ':role'=>$role,
                ':id'=>$id,
            ]);
            if($result){
                echo "<script>alert('Successfully User Updated!');window.location.href='userindex.php';</script>";
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
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">User Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $result['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Enter Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $result['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Enter Password:</label>
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $result['password']; ?>" required>
                </div>
                <div class="form-check mb-5">
                    <input class="form-check-input" type="checkbox" value="1" id="role" name="role" <?php echo ($result['role']==1?'checked':''); ?>>
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
