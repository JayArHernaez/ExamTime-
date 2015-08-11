<?php
  session_start();
  include("../db_connect.php");
  
  if(isset($_SESSION['role']) && $_SESSION['role'] == 'student'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '{$_SESSION['username']}'");
    $row = mysqli_fetch_assoc($fetch);

     $u1 = mysqli_query($db, "SELECT DISTINCT examID FROM tb_assign_exam WHERE studentNo = '{$_SESSION['studno']}' AND status = '1'");
      $u2 = mysqli_num_rows($u1);
      $_SESSION['notif'] = $u2;
  }else{
    header("Location: ../index.php");
  }
  $_SESSION['setEx'] = 0;



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
           <a href="../logout.php"> <button id="logout" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Log Out</button></a>
			
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
	
	
	
  <nav class="navbar navbar-inverse navbar-fixed-left" role="navigation">
      <div class="container" >
        <div id="list-group ">
          <ul class="nav nav-pills nav-stacked">
            <a ><img class="img-circle" src="<?='../uploads/'.$row['profilePic']?>" alt="Generic placeholder image" width="150" height="150" style="padding:20px;"></a>
            
            <li><a class="nav-stacked" href="student.php"><i class="fa fa-dashboard fa-fw "></i>  Dashboard</a></li>
            <li><a class="nav-stacked" href="profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
            <li class="active"><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams<?php if($_SESSION['notif']>0) echo "&nbsp;<span class=\"badge pull-right\">".$_SESSION['notif']."</span>";?></a></li>
            <li><a class="nav-stacked" href="my_groups.php"><i class="fa fa-users fa-fw"></i>My Groups</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user">
        <div class="page-header"><center><h2><strong>My Exams</strong></h2></center></div>
         <div class="panel panel-danger">
           <div class="panel-heading">
              <h2 class="panel-title"><strong>New Exams!</strong></h2>
           </div>
           <div class="panel-body">
              <table class="table table-hover table-bordered" id="student-exam-view">
                <thead>
                  <tr>
                  <center>
                    <th>Exam Title</th>
                    <th>Creator</th>
                    <th>Exam Date</th> 
                    <th><center>Option</center></th>
                  </center>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $fetch = mysqli_query($db, "SELECT DISTINCT examID FROM tb_assign_exam WHERE studentNo = '{$_SESSION['studno']}' AND status = '1'");
                      $numrow = mysqli_num_rows($fetch);

                      for ($i=0; $i < $numrow ; $i++) { 
                        $res = mysqli_fetch_assoc($fetch);
                        
                        $f2 = mysqli_query($db, "SELECT examTitle, examDate, employeeNo from tb_exam where examID = '{$res['examID']}'");
                        $res2 = mysqli_fetch_assoc($f2);

                        $f3 = mysqli_query($db, "SELECT firstname, lastname from tb_instructor where employeeNo = '{$res2['employeeNo']}'");
                        $res3 = mysqli_fetch_assoc($f3);
                      ?>
                        <tr>
                          <td><?=$res2['examTitle']?></td>
                          <td><?=ucfirst($res3['firstname'])." ".ucfirst($res3['lastname'])?></td>
                          <td><?=$res2['examDate']?></td>
                          <?php
                            //check for the date of exam, allow to take the exam if today is exam date
                              $today = date("Y-m-d");
                              $today_dt = new DateTime($today);

                              $examdate = new DateTime($res2['examDate']);

                              if($examdate < $today_dt) {
                                $upd = mysqli_query($db, "UPDATE tb_assign_exam set status = '0' where examID = '{$res['examID']}' and studentNo = '{$_SESSION['studno']}'");
                                $_SESSION['notif'] -= 1;

                                header("Location: my_exams.php");
                              }

                          ?>
                          <td><center><a href="<?php if ($examdate == $today_dt) echo"answer_exam.php?qAz=".base64_encode(base64_encode($res2['examTitle']))."&&RgBjI=".base64_encode($res['examID']);  
                          ?>">
                          <button name="take_exam" type="button" class="btn btn-primary" 
                          <?php 
                              if ($examdate != $today_dt) { 
                                echo "disabled";
                              }

                           ?> ><i class="fa fa-pencil-square-o"></i> Take Exam</button></a></center></td>
                        </tr>
                      <?php
                      }//forloop

                  ?>
                  
                </tbody>
              </table>
           </div>
        </div>

        <div class="panel panel-success">
           <div class="panel-heading">
              <h3 class="panel-title"><strong>My Past Exams</strong></h3>
           </div>
           <div class="panel-body">
              <table class="table table-hover table-bordered" id="student-exam-view">
                <thead>
                  <tr>
                    <th>Exam Title</th>
                    <th>Creator</th>
                    <th>Score</th>
                    <th>Percentage</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $fetch = mysqli_query($db, "SELECT DISTINCT examID, result FROM tb_assign_exam WHERE studentNo = '{$_SESSION['studno']}' AND status = '0'");
                      $numrow = mysqli_num_rows($fetch);

                      for ($i=0; $i < $numrow ; $i++) { 
                        $res = mysqli_fetch_assoc($fetch);
                        
                        $f2 = mysqli_query($db, "SELECT examTitle, employeeNo from tb_exam where examID = '{$res['examID']}'");
                        $res2 = mysqli_fetch_assoc($f2);

                         $f3 = mysqli_query($db, "SELECT firstname, lastname from tb_instructor where employeeNo = '{$res2['employeeNo']}'");
                        $res3 = mysqli_fetch_assoc($f3);
                  ?>
                  <tr>
                    <td><?=$res2['examTitle']?></td>
                     <td><?=ucfirst($res3['firstname'])." ".ucfirst($res3['lastname'])?></td>
                    <td><?=$res['result']?></td>
                    <td><?php
                        $f4 = mysqli_query($db, "SELECT questionID from tb_question where examID = '{$res['examID']}'");
                        $f4c = mysqli_num_rows($f4);

                        if ($f4c == 0) {
                          $f4c++;
                        }

                        $percent = (float) ($res['result']/ $f4c)*100;
                        //$percent = (int) (65/80)*100;
                        echo $percent."%";
                    ?></td>
                  </tr>
                  <?php
                      }//forloop
                  ?>
                </tbody>
              </table>
           </div>
        </div>

        
        <br>
		   

        
        <br><br>
      </div>
    </div>

   
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
