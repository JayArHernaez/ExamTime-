<?php

	session_start();
	include("../db_connect.php");

  if(isset($_SESSION['role']) && $_SESSION['role'] == 'instructor'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_instructor WHERE employeeNo = '{$_SESSION['empno']}'");
    $row = mysqli_fetch_assoc($fetch);
  }else{
    header("Location: ../index.php");
  }
  
  //$view_count = count($_POST['view']);
 // var_dump($view_count);


?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="icon" type="img/png" href="../img/ebicon.png">
        <title>Examtime - Time to build exams!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="../css/bootstrap_users.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../css/main.css">

        <script src="../js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
         <style type="text/css">
            th,td{
              text-align: center;
            }
        </style>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src=../img/logo.png></img></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
		  
          <ul class="nav navbar-top-links navbar-right">
      			<li><a id=""><?="Welcome ".ucfirst($row['firstname'])."!" ?></a></li>
            <a href="../logout.php"><button id="logout" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Log Out</button></a>
			
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
	
	
	
  <nav class="navbar navbar-inverse navbar-fixed-left" role="navigation">
      <div class="container" >
        <div id="list-group ">
          <ul class="nav nav-pills nav-stacked">
            <a ><img class="img-circle" src="<?='../uploads/'.$row['profilePic']?>" alt="Generic placeholder image" width="150" height="150" style="padding:20px;"></a>
            
            <li><a class="nav-stacked" href="instructor.php"><i class="fa fa-dashboard fa-fw "></i>  Dashboard</a></li>
            <li><a class="nav-stacked" href="profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
            <li class="active"><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams</a></li>
            <li><a class="nav-stacked" href="my_students.php"><i class="fa fa-users fa-fw"></i> My Students</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user">
        <div class="panel panel-success">
           <div class="panel-heading">
              <h3 class="panel-title"><strong>My Exams</strong></h3>
           </div>
           <div class="panel-body">
            <div class="alert alert-info" role="alert">
              This is the list of all exams you made.
            </div>
            <form role="form" method="post">
              <table class="table table-hover table-bordered" id="student-exam-view">
                <thead>
                  <tr>
                    <th>Exam Id</th>
                    <th>Exam Title</th>
                    <th>Exam Takers
                    <th>Exam Date</th>
                    <th>Time Allotted</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                
                <?php 
                    $fetch = mysqli_query($db, "SELECT * FROM tb_exam WHERE employeeNo = '".$_SESSION['empno']."'");
                    $num_r = mysqli_num_rows($fetch);
                      for ($i=0; $i < $num_r; $i++) { 
                        $row = mysqli_fetch_assoc($fetch);
                ?>
                  <tr>
                    <td><?=$row['examID']?></td>
                    <td><?=$row['examTitle']?></td>
                    <td><?=$row['examTakers']?></td>
                    <td><?=$row['examDate']?></td>
                    <td><?php 
                      $tme = date_parse($row['timeAlloted']);
                      $compute = $tme['hour']*60+$tme['minute'];
                      echo "$compute"." minute(s)";
                    ?>
                    </td>
                    <td><center><a href="<?="view_exam.php?view=".$row['examTitle']?>" ><button name="view[]" type="button" class="btn btn-primary" ><i class="fa fa-eye"></i> View</button></a></center></td>
                  </tr>
                <?php
                     // $counter++;
                    }//forloop
                ?>
               
                </tbody>
              </table>

              </form>
           </div>
        </div>

        
        <br>
		    <center>
          <a href="create_exam.php"><button id="create_exam" type="submit" class="btn btn-success"><i class="fa fa-file-text-o"></i> Create New</button></a>
        </center>
      </div>
    </div>

    <!--Modal form for Adding Student-->
    <div id="createExam-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Input Details</h4>
              </div>
              <div class="modal-body">
                <form role="form" method="post" id="register-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-university"  ></i></span>
                        <input name="studentNo" id="reg-studno" type="text" class="form-control" placeholder="Enter Student Number" maxlength="10" required/>
                    </div>
                    <p class="reg-error" id="grp-acct">* Please input a valid student number.</p>

          <div class="modal-footer">
            <button name="addStudent" type="submit" class="btn btn-success" id="register-btn">Add</button>
          </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Add Student-->
   
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="../js/vendor/bootstrap.min.js"></script>

        <script src="../js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
        <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </body>
</html>
