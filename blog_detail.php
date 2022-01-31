<?php
require('config/config.php');
     session_start();
     if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
       header('Location:login.php');
     }
    
    $stmt=$db->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();
    $result=$stmt->fetch();
    // print_r($result['title']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main content -->
        <section class="content my-5">
            <div class="container-fluid">
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
                            </div>
                            
                            <!-- /.card-body -->
                            <div class="card-footer card-comments">
                                <div class="card-comment">
                                <!-- User image -->
                                    <img class="img-circle img-sm" src="dist/img/user3-128x128.jpg" alt="User Image">

                                    <div class="comment-text">
                                        <span class="username">
                                            Maria Gonzales
                                        <span class="text-muted float-right">8:03 PM Today</span>
                                        </span><!-- /.username -->
                                        It is a long established fact that a reader will be distracted
                                        by the readable content of a page when looking at its layout.
                                    </div>
                                    <!-- /.comment-text -->
                                </div>
                                <!-- /.card-comment -->
                                <div class="card-comment">
                                <!-- User image -->
                                    <img class="img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="User Image">

                                    <div class="comment-text">
                                        <span class="username">
                                        Luna Stark
                                        <span class="text-muted float-right">8:03 PM Today</span>
                                        </span><!-- /.username -->
                                        It is a long established fact that a reader will be distracted
                                        by the readable content of a page when looking at its layout.
                                    </div>
                                <!-- /.comment-text -->
                                </div>
                                <!-- /.card-comment -->
                            </div>
                            <div class="card-footer">
                                <form action="#" method="post">
                                <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <footer class="main-footer" style="margin-left:0; !important">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.5
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
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
