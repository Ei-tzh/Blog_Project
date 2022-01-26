<?php
require('../config/config.php');
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location:login.php');
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
              $stmt=$db->prepare('SELECT * FROM posts ORDER BY id DESC');
              $stmt->execute();
              $result=$stmt->fetchALL();
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
