<?php

     session_start();
     require('config/config.php');
     require('config/common.php');
     if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
       header('Location:login.php');
     }
     if(empty($_GET['pageno'])){
        $pageno=1;
     }
    else{
        $pageno=$_GET['pageno'];
    }
    $numOfrec=6;
    $offset=($pageno-1)*$numOfrec;

    $rawstmt=$db->prepare('SELECT * FROM posts ORDER BY id DESC');
    $rawstmt->execute();
    $rawresult=$rawstmt->fetchALL();

    $totalpages=ceil(count($rawresult)/$numOfrec);

    $stmt=$db->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrec");
    $stmt->execute();
    $result=$stmt->fetchALL();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blogs</title>
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
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="text-center">Blog Site</h1>
            </div><!-- /.container-fluid -->
        </section>
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                        if($result):
                            foreach($result as $value): ?>
                                <div class="col-md-4">
                                    <div class="card card-widget">
                                        <div class="card-header text-center text-uppercase">
                                            <h4><?= escape($value['title']) ?></h4>
                                        </div>
                                        
                                        <div class="card-body">
                                            <a href="blog_detail.php?id=<?php echo escape($value['id']); ?>"><img  src="admin/<?= escape($value['image']) ?>" alt="Photo" style="width:100%;height:200px;object-fit:cover;"></a>   
                                    </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div> 
                        <?php
                            endforeach;
                        endif; ?>
                </div>
                
                <nav aria-label="Page navigation example" class="mt-2 mb-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno<=1){ echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($pageno<=1){ echo '#' ;}else{ echo '?pageno='. ($pageno-1);} ?>">
                        Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno>=$totalpages){ echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($pageno>=$totalpages){ echo '#' ;}else{ echo '?pageno='. ($pageno+1);} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="<?php echo '?pageno='.$totalpages ?>">Last</a></li>
                </ul>
                </nav>    
            </div><!-- /.container-fluid -->
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
