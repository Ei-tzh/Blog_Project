<?php
require('config/config.php');
     session_start();
     if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
       header('Location:login.php');
     }
    
    $stmt=$db->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();
    $result=$stmt->fetch();
    
    $blogid=$_GET['id'];
    $stmtcmt=$db->prepare("SELECT * FROM comments WHERE post_id=$blogid");
    $stmtcmt->execute();
    $cmResult=$stmtcmt->fetchAll();
    if($cmResult){
        $auresult=[];
        foreach($cmResult as $key=>$value){
            $authorID=$cmResult[$key]['author_id'];
            $stmtuser=$db->prepare("SELECT * FROM users WHERE id=$authorID");
            $stmtuser->execute();
            $auresult[]=$stmtuser->fetch();
        }
        // print "<pre>";
        // print_r($auresult[1]);
        // exit();
    }
    
    // print_r($cmResult[0]['author_id']);
    // exit();
    

    if($_POST){
        $comment=$_POST['comment'];

        $stmt=$db->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
        $result=$stmt->execute([
            ":content"=>$comment,
            ":author_id"=>$_SESSION['user_id'],
            ":post_id"=>$blogid,
        ]);
        if($result){
            header('Location:blog_detail.php?id='.$blogid);
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Details</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main content -->
        <section class="content my-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Box Comment -->
                        <div class="card card-widget">
                            <div class="card-header text-center">
                                <h4><?= $result['title'] ?></h4>
                            </div>
                            <div class="card-body">
                                <img class="img-fluid pad" src="admin/<?= $result['image'] ?>" alt="Photo">
                                <p class="card-text"><?= $result['content']?></p>
                                <h3>Comments</h3><hr>
                                <a href="index.php?pageno=1" class="btn btn-default">Back</a>
                            </div>
                            
                            <!-- /.card-body -->
                            <div class="card-footer card-comments">
                                <?php if($cmResult):
                                     foreach($cmResult as $key=>$value): ?>
                                    <div class="card-comment d-flex justify-content-between">
                                        <div class="comment-text">
                                            <i class="far fa-user"></i>
                                            <span class="font-weight-bold ml-2 text-capitalize"><?= $auresult[$key]['name'] ?>
                                            </span><!-- /.username -->
                                            <div style="margin-left:45px;">
                                                <?= $value['content'] ?>
                                            </div> 
                                        </div>
                                        <div class="text-muted datetime"><?= $value['created_at'] ?></div>
                                    </div>
                                <?php   endforeach;
                                    else: ?>
                                            <p class="alert alert-info">No Comment!</p>
                            <?php   endif; ?>    
                               
                            </div>
                            <div class="card-footer">
                                <form action="" method="post">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-user"></i></span>
                                        </div>
                                        <input type="text" name="comment" class="form-control " placeholder="Press enter to post comment">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        </section>
        <footer class="main-footer mb-2" style="margin-left:0; !important">
            <!-- To the right -->
            <div class="container">
                <div class="float-right d-none d-sm-inline">
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                </div>
                <strong>Copyright &copy; 2022 <a href="#">A programmer</a>.</strong> All rights reserved.
            </div>
        </footer>
    </div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
