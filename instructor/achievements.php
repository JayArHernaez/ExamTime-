<?php
  session_start();
  include("../db_connect.php");
  
  if(isset($_SESSION['role']) && $_SESSION['role'] == 'instructor'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_instructor WHERE employeeNo = '{$_SESSION['empno']}'");
    $row = mysqli_fetch_assoc($fetch);
  }else{
    header("Location: ../index.php");
  }
  
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
            <li><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams</a></li>
            <li><a class="nav-stacked" href="my_students.php"><i class="fa fa-users fa-fw"></i> My Students</a></li>
            <li class="active"><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user">
      <div class="page-header"><center><h2><strong>Achievements</strong></h2></center></div>
        <div class="panel panel-warning">
           <div class="panel-heading">
              <h3 class="panel-title">
                <center>
                  <i class="fa fa-trophy fa-5x" style="color:gold"></i>
                  <i class="fa fa-trophy fa-5x" style="color:silver" ></i>
                  <i class="fa fa-trophy fa-5x" style="color:#cd7f32"></i>
                </center>
              </h3>
           </div>
           <div class="panel-body">
           <div class="alert alert-info" role="alert">
              Here are your achievements so far. Create more! :)
           </div>
              <table class="table table-hover table-bordered" id="student-table-achiv">
                <thead>
                  <tr>
                    <td>Trophy</td>
                    <td>Description</td>
                    <td>Count</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="fa fa-trophy fa-2x" style="color:gold"></i></td>
                    <td>Have a passing rate of 91-100% on an exam, or<br>Get a 91-100% of good approval rating for an exam.</td>
                    <td>0</td>
                  </tr>
                  <tr>
                    <td><i class="fa fa-trophy fa-2x" style="color:silver" ></i></td>
                    <td>Have a passing rate of 81-90% on an exam, or<br>Get a 81-90% of good approval rating for an exam.</td>
                    <td>0</td>
                  </tr>
                  <tr>
                    <td><i class="fa fa-trophy fa-2x" style="color:#cd7f32"></i></td>
                    <td>Have a passing rate if 71-80% on an exam, or<br>Get a 71-80% of good approval rating for an exam.</td>
                    <td>0</td>
                  </tr>
                </tbody>
              </table>


              <br>
              
              <table class="table table-hover table-bordered" id="student-table-achiv">
                <thead>
                  <tr>
                    <td style="text-align:center">Overall Average Passing of Created Exams</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align:center">%</td>
                  </tr>
                </tbody>
              </table>
             
           </div>
        </div>

        <p>
		    </p>
        <br><br>
		
      </div>
    </div>

   
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

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
