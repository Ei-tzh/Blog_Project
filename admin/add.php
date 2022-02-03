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
      $title=$_POST['title'];
      $content=$_POST['content'];

      $files='images/'.$_FILES['image']['name'];
      $tmp=$_FILES['image']['tmp_name'];
      $imagetype=pathinfo($files,PATHINFO_EXTENSION);
      
      if($imagetype != 'png' && $imagetype!= 'jpg' && $imagetype!='jpeg'){
          echo "<script>alert('Image must be jpg,png,jpeg.');</script>";
      }else{
          move_uploaded_file($tmp,$files);
          $stmt=$db->prepare("INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
          $result=$stmt->execute([
              ':title'=>$title,
              ':content'=>$content,
              ':image'=>$files,
              ':author_id'=>$_SESSION['user_id'],
          ]);
          if($result){
            echo "<script>alert('Successfully Added!');window.location.href='index.php';</script>";
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
            <form action="add.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="10" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control py-1" type="file" id="image" name="image" required>
                </div>
                <input type="submit" value="Add" class="btn btn-success">
                <a href="index.php" class="btn btn-secondary">Back</a>
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
