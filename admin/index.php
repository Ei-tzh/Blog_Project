<?php
require('../config/config.php');
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
  }else{
    $userID=$_SESSION['user_id'];

    $stmt=$db->prepare("SELECT * FROM users WHERE id=$userID");
    $stmt->execute();
    $result=$stmt->fetch();

    if($result['role']==0){
      echo "<script>alert('Sorry,Only Admin can enter!');window.location.href='login.php';</script>";
    }
  }
  //print_r($_SESSION);

?>

<?php include('header.html'); ?>

  <!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Blog Listings</h3>
          </div>
          <!-- /.card-header -->
          <?php
            if(!empty($_GET['pageno'])){
              $pageno=$_GET['pageno'];
            }else{
              $pageno=1;
            }
            $num_of_rec=2;
            $offset=($pageno-1)*$num_of_rec;

            if(empty($_POST['search'])){
              $stmt=$db->prepare('SELECT * FROM posts ORDER BY id DESC');
              $stmt->execute();
              $rawresult=$stmt->fetchALL();
              $totalpage=ceil(count($rawresult)/$num_of_rec);

              $stmt=$db->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$num_of_rec");
              $stmt->execute();
              $result=$stmt->fetchALL();
            }else{
              $searchkey=$_POST['search'];
              
              $stmt=$db->prepare("SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC");
              $stmt->execute();
              $rawresult=$stmt->fetchALL();
              $totalpage=ceil(count($rawresult)/$num_of_rec);

              $stmt=$db->prepare("SELECT * FROM posts WHERE title LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$num_of_rec");
              $stmt->execute();
              $result=$stmt->fetchALL();
            }

              // $totalpage=ceil(50/7);//value nearest number.
              // echo $totalpage;
              // print_r($result[0]['content']);
          ?>
          <div class="card-body">
            <a href="add.php" class="btn btn-success mb-3">New Blog Post</a>
            <table class="table table-bordered">
              <thead>                  
                <tr>
                  <th style="width: 10px">ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if($result):
                      $i=1;
                      foreach($result as $value): ?>
                        <tr>
                          <td><?= $i ?></td>
                          <td><?= $value['title'] ?></td>
                          <td><?= substr($value['content'],0,50) ?></td>
                          <td>
                            <a href="edit.php?id=<?= $value['id'] ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                          </td>
                        </tr>
                <?php
                        $i++;
                      endforeach;
                    endif;
                ?>
                
              </tbody>
            </table>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end mt-3">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if($pageno<=1){ echo 'disabled';}?>"><a class="page-link" href="<?php if($pageno<=1){echo '#';} else{ echo "?pageno=".($pageno-1);} ?>">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                <li class="page-item <?php if($pageno>=$totalpage){ echo 'disabled';}?>"><a class="page-link" href="<?php if($pageno>=$totalpage){echo '#';} else{ echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpage; ?>">Last</a></li>
              </ul>
            </nav>
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
