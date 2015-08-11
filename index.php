<?php
	session_start();
	include("db_connect.php");
	
	/*$users = mysqli_query($db, "SELECT * FROM tb_student");
	while($row = mysqli_fetch_assoc($users)){
		echo "Username: ".$row['studentNo'];
	}*/
	
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'instructor'){
		header("Location: instructor/instructor.php");
	}else if(isset($_SESSION['role']) && $_SESSION['role'] == 'student'){
		header("Location: student/student.php");
	}
	
  $result1 = 1;
  $result2 = 1;

	if(isset($_POST['login'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		
		$users1 = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '".$username."' AND password = '".$password."'");
		$result1 = mysqli_num_rows($users1);
		$users2 = mysqli_query($db, "SELECT * FROM tb_instructor WHERE username = '".$username."' AND password = '".$password."'");
		$result2 = mysqli_num_rows($users2);
		
		if($result1 > 0){
			$_SESSION['username'] = $username;
			$_SESSION['role'] = 'student';
      $row = mysqli_fetch_assoc($users1);
      $_SESSION['studno'] = $row['studentNo']; //temp var that can be used anywhere in diff pages
      //get number of untaken exams
      $u1 = mysqli_query($db, "SELECT DISTINCT examID FROM tb_assign_exam WHERE studentNo = '{$_SESSION['studno']}' AND status = '1'");
      $u2 = mysqli_num_rows($u1);
      $_SESSION['notif'] = $u2;
     
     // echo $_SESSION['studno'];
			header("Location: student/student.php");
		}else if($result2 > 0){
			$_SESSION['username'] = $username;
			$_SESSION['role'] = 'instructor';
      $row = mysqli_fetch_assoc($users2);
      $_SESSION['empno'] = $row['employeeNo']; //temp var that can be used anywhere in diff pages
      $_SESSION['profilepic'] = $row['profilePic'];
      //echo $_SESSION['empno'];
			header("Location: instructor/instructor.php");
		}else{
      echo "<script>alert(\"Invalid username and password combination.\")</script>";
    }

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
		<link rel="icon" type="img/png" href="img/ebicon.png">
        <title>Examtime - Time to build exams!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.css">

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
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
          <a class="navbar-brand" href="#"><img src=img/logo.png></img></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
		  
          <ul class="nav navbar-top-links navbar-right">
      			<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      			<li><a href="features.php"><i class="fa fa-coffee"></i> Features</a></li>
      			<li><a href = "#about"><i class="fa fa-users"></i> About Us</a></li>
      			<li><a id="login"><i class="fa fa-sign-in"></i> Login</a></li>
            <button name="signup" id="signup" type="submit" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Sign Up</button>
			
          </ul>
        </div><!--/.navbar-	collapse -->
      </div>
    </nav>

    <!--Modal Form for Logging In-->
    <div id="login-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Enter Details</h4>
              </div>
              <div class="modal-body">
                <form id="login-form" role="form" action="" method="post">
                  <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                    <input name="username" type="text" class="form-control" placeholder="Username" id="login-uname" required />
                    <br><p id=""></p>
                  </div>
                   
                  <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                    <input name="password" type="password" class="form-control"  placeholder="Password" id="login-pass" required />
                  </div>

                  <div class="form-group">
                    <label class="checkbox-inline">
                      <input type="checkbox" /><a>Remember me</a>
                    </label>
                    <span class="pull-right">
                     <a href="#" >Forget password ? </a> 
                    </span>
                  </div>
                
					<?php if ($result1 <1 && $result2<1) {
            echo "<p class=\"login-error\" id=\"grp-login\">* Invalid username and password combination.</p>";
          }?>
				  </div>
				  <div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  <button name="login" type="submit" class="btn btn-primary" value="" id="login-btn">Log In</button>
				  </div>
			  </form>
          </div>
      </div>
    </div>
    <!--end: modal form for log in-->

    <!--Modal form for Signing Up-->
    <div id="signup-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Please Accomplish This Form</h4>
              </div>
              <div class="modal-body">
                <form action="register.php" role="form" method="post" id="register-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input name="firstname" id="reg-first" type="text" class="form-control" placeholder="First Name" maxlength="25" required/>
                        <input name="lastname" id="reg-last" type="text" class="form-control" placeholder="Last Name" maxlength="25" required/>
                    </div>
                    <p class="reg-error" id="grp-name">* Enter a valid First and Last name.</p>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                        <input name="username" id="reg-uname" type="text" class="form-control" placeholder="Desired Username" maxlength="15" required/>
                    </div>
                    <p class="reg-error" id="grp-uname">* Username must contain atleast 5 alphanumeric characters.</p>
                                        
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                        <select name="accountType" id="reg-acct" class="form-control" required>
                            <option value="act" selected>Account Type</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Student">Student</option>
                        </select>
                    </div>
                    <p class="reg-error" id="grp-acct">* Please input a valid identification for your Account Type.</p>
                    
                    <div class="form-group input-group" style="display:none" id="student-input" >
                        <span class="input-group-addon"><i class="fa fa-university"  ></i></span>
                          <input name="studentNo" id="reg-studno" type="text" class="form-control" placeholder="Student Number" maxlength="10" required/>
                    </div>

                    <div class="form-group input-group" style="display:none" id="emp-input" >
                        <span class="input-group-addon"><i class="fa fa-university"  ></i></span>
                          <input name="employeeNum" id="reg-empno" type="text" class="form-control" placeholder="Employee Number" maxlength="10" required/>
                    </div>
                    

                    <div class="form-group input-group">
                        <span class="input-group-addon">@</span>
                          <input name="email" id="reg-email" type="email" class="form-control" placeholder="Your Email" maxlength="40" required/>
                    </div>
                    <p class="reg-error" id="grp-email">* Please input a valid e-mail address.</p>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input name="password" id="reg-pass" type="password" class="form-control" placeholder="Enter Password" maxlength="25" required/>                       
                    </div>
                    <p class="reg-error" id="grp-pass">* Use atleast 5 alphanumeric symbols only.</p>
                    
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input id="reg-rpass" type="password" class="form-control" placeholder="Re-enter Password" maxlength="25" required />
                    </div>
                    <p class="reg-error" id="grp-rpass">* Password does not match.</p>
					<div class="modal-footer">
						<button name="register" type="submit" class="btn btn-success" id="register-btn" >Register Me!</button>
					</div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Sign Up-->

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1><b>Time for that Exam!</b></h1>
        <p>
          <!--CONTENT CONTENT CONTENT-->
          
        </p>
        <br><br>
		<p class="btn-a">
			<a class="btn btn-primary btn-lg" href="#" role="button">Create Exam &raquo;</a>
			<a class="btn btn-primary btn-lg" href="#" role="button">Answer Exam &raquo;</a>
		</p>
      </div>
    </div>

    <!--About the Developers-->
    <div class="container">
    <center>
      <a id="about">
        <h2> About the Developers </h2>
      </a>
      <br>
    
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
        	 <img class="img-circle" src="img/dev1.jpg" alt="Generic placeholder image" width="120" height="120">
          <h4>Charles Jayson Dadios</h4>
         
        </div>

        <div class="col-md-4">
         <img class="img-circle" src="img/dev2.jpg" alt="Generic placeholder image" width="120" height="120">
         <h4>Pamela Mari Santos</h4>
       </div>

        <div class="col-md-4">
         <img class="img-circle" src="img/dev3.jpg" alt="Generic placeholder image" width="120" height="120">
          <h4>Jay-Ar Hernaez</h4>
          
        </div>
         <div class="col-md-4">
          <img class="img-circle" src="img/dev4.jpg" alt="Generic placeholder image" width="120" height="120">
          <h4> Marvin Duba </h4>
          
       </div>
        <div class="col-md-4">
         <img class="img-circle" src="img/dev5.jpg" alt="Generic placeholder image" width="120" height="120">
          <h4>Bernadette Magat</h4>
          
       </div>
       </center>
      </div>
      <!--About the Developers End-->

      <br><br>
      <hr>
      <footer>
        <center><strong>Copyright &copy; 2015 Institute of Computer Science, University of the Philippines Los Baños.</strong></center>
        
      </footer>
     
    </div> 

    <!-- /container -->        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
        <script src="js/validate.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>

        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </body>
</html>
