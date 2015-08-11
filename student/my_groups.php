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
   
    //leaving a group
	if(isset($_POST['leavegrp'])){
    	$group = htmlspecialchars($_POST['Groupname']);

		$deleteStudent = mysqli_query($db,"DELETE FROM tb_in_group WHERE studentNo='{$_SESSION['studno']}' AND groupname='{$group}'");
		

		if($deleteStudent){
			echo "<script>alert(\"You successfully left the group!\")</script>";
		}else{
			echo "<script>alert(\"Operation Unsuccessful.\")</script>";
			//mysqli_error($db);
		}
    header("Location: my_groups.php");
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
            <li><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams<?php if($_SESSION['notif']>0) echo "&nbsp;<span class=\"badge pull-right\">".$_SESSION['notif']."</span>";?></a></li>
            <li class="active"><a class="nav-stacked" href="my_groups.php"><i class="fa fa-users fa-fw"></i>My Groups</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user">
        <div class="page-header"><center><h2><strong>My Groups</strong></h2></center></div>
         
        <div class="panel panel-success">
           <div class="panel-heading">
              <h3 class="panel-title"><strong></strong></h3>
           </div>
           <div class="panel-body">
           	 <div class="alert alert-info" role="alert">
                Here are the groups or classes where you are included.
              </div>
              <table class="table table-hover table-bordered" id="student-exam-view">
                <thead>
                  <tr>
                    <th>Group Name</th>
                    <th>Instructor</th>
                    <th>Email Address</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   	$f2 = mysqli_query($db, "SELECT groupname from tb_in_group where studentNo = '{$_SESSION['studno']}'");
                    $numrow = mysqli_num_rows($f2);

                      for ($i=0; $i < $numrow ; $i++) { 
                        $res = mysqli_fetch_assoc($f2);
                        
                        $f3 = mysqli_query($db, "SELECT employeeNo from tb_group where groupname = '{$res['groupname']}'");
                        $res3 = mysqli_fetch_assoc($f3);
                        

                         $f4 = mysqli_query($db, "SELECT firstname, lastname, email from tb_instructor where employeeNo = '{$res3['employeeNo']}'");
                        $res4 = mysqli_fetch_assoc($f4);
                  ?>
                  <tr>
                    <td><?=$res['groupname']?></td>
                     <td><?=ucfirst($res4['firstname'])." ".ucfirst($res4['lastname'])?></td>
                    <td><?=$res4['email']?></td>

                  </tr>
                  <?php
                      }//forloop
                  ?>
                </tbody>
              </table>
           </div>
        </div>

        <center><button id="leavegrp-btn" class="btn btn-danger"><i class="fa fa-user-times"></i> Leave a Group</button></center>
        <br>
		   

        
        <br><br>
      </div>
    </div>
     <!--Modal form for Adding a Group-->
    <div id="leaveGroup-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Leave Group</h4>
              </div>
              <div class="modal-body">
                <form role="form" method="post" id="add-group-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-users"  ></i></span>
                        <input name="Groupname" id="grpname" type="text" class="form-control" placeholder="Enter Group Name" maxlength="20" required/>
                    </div>
                   
                    <div class="modal-footer">
       					By clicking the button, you automatically disconnect yourself from the group.<br>
                      <button name="leavegrp" type="submit" class="btn btn-danger" id="leaveGroup"><i class="fa fa-user-times"></i> Leave Now</button>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Leave Group-->

   
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
