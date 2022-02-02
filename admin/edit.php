<?php
require('../config/config.php');
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
  }
  //print_r($_SESSION);
  $stmt=$db->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();
  $result=$stmt->fetch();
 if($_POST){
     $id=$_POST['id'];
     $title=$_POST['title'];
     $content=$_POST['content'];
     
     if($_FILES['image']['name'] != null){
        $files='images/'.$_FILES['image']['name'];
        $tmp=$_FILES['image']['tmp_name'];
        $imagetype=pathinfo($files,PATHINFO_EXTENSION);
        
            if($imagetype != 'png' && $imagetype!= 'jpg' && $imagetype!='jpeg'){
                echo "<script>alert('Image must be jpg,png,jpeg.');</script>";
                }else{
                    move_uploaded_file($tmp,$files);
                    $stmt=$db->prepare("UPDATE posts SET title=:title,content=:content,image=:image WHERE id=:id");
                    $result=$stmt->execute([
                        ':title'=>$title,
                        ':content'=>$content,
                        ':image'=>$files,
                        ':id'=>$id,
                    ]);
                    if($result){
                    echo "<script>alert('Successfully Added!');window.location.href='index.php';</script>";
                        }
                    }
        }else{
            $stmt=$db->prepare("UPDATE posts SET title=:title,content=:content WHERE id=:id");
            $result=$stmt->execute([
                ':title'=>$title,
                ':content'=>$content,
                ':id'=>$id,
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
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $result['title'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="10" required><?php echo $result['content'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label><br>
                    <img src="<?php echo $result['image'] ?>" alt="" class="img-thumbnail w-25 h-25 mb-2">
                    <input class="form-control py-1" type="file" id="image" name="image">
                </div>
                <input type="submit" value="Edit" class="btn btn-success">
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
