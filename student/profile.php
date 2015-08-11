<?php
  session_start();
  include("../db_connect.php");
  
  if(isset($_SESSION['role']) && $_SESSION['role'] == 'student'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '{$_SESSION['username']}'");
    $row = mysqli_fetch_assoc($fetch);
    
    if(isset($_POST['save'])){
      $studentNo = $_POST['studentNo'];

      $fetch = mysqli_query($db, "SELECT password FROM tb_student WHERE studentNo = '{$studentNo}'");
      $row = mysqli_fetch_assoc($fetch);
      $counter = mysqli_num_rows($fetch);

      $currPassword = $_POST['currPassword'];
      if($counter > 0 && $row['password'] === $currPassword){
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        //$profpic = htmlspecialchars($_POST['profPic']);

        $newPassword = $_POST['newPassword'];
        if(!isset($newPassword) || trim($newPassword) == '')
        {
           $newPassword = $currPassword;
        }
        
        function GetImageExtension($imagetype){
         if(empty($imagetype)) return false;
         switch($imagetype)
         {
             case 'image/bmp': return '.bmp';
             case 'image/gif': return '.gif';
             case 'image/jpeg': return '.jpg';
             case 'image/png': return '.png';
             default: return false;
         }
        }
       // Updating profile image
       
       if (!empty($_FILES["profPic"]["name"])) {
              $file_name=$_FILES["profPic"]["name"];
              $temp_name=$_FILES["profPic"]["tmp_name"];
              $imgtype=$_FILES["profPic"]["type"];
              $ext= GetImageExtension($imgtype);
              $imagename=$_SESSION['studno'].$ext;

             $target_path = "../uploads/".$imagename;
          
          if(file_exists("../uploads/".$imagename)) unlink("../uploads/".$imagename);

          if(move_uploaded_file($temp_name, $target_path)) {
             $query_upload="UPDATE tb_student set profilePic = '{$imagename}' WHERE studentNo = '{$studentNo}' AND password = '{$currPassword}'";
              $uploaded = mysqli_query($db,$query_upload) or die("error in $query_upload == ----> ".mysql_error()); 
          }else{
             echo "<script>alert('Image upload error.')</script>";
          }
        }

        $editStudent = mysqli_query($db, "UPDATE tb_student SET username = '{$username}', firstname = '{$firstname}', lastname = '{$lastname}', 
          password = '{$newPassword}', email = '{$email}' WHERE username = '{$_SESSION['username']}'");
        $_SESSION['username'] = $username;
        $_SESSION['message'] = "Profile Successfully Updated!";
        header("Location: profile.php");
      }else{
        echo "<script>alert(\"Invalid Password.\")</script>";
        header("Location: profile.php");
      }

      
    }

    //$fetch = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '{$_SESSION['username']}'");
    //$row = mysqli_fetch_assoc($fetch);
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
            <a href = "../logout.php"><button type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Log Out</button></a>
      
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
  
  
  
  <nav class="navbar navbar-inverse navbar-fixed-left" role="navigation">
      <div class="container" >
        <div id="list-group ">
          <ul class="nav nav-pills nav-stacked">
            <a ><img class="img-circle" src= "<?='../uploads/'.$row['profilePic']?>" alt="Generic placeholder image" width="150" height="150" style="padding:20px;"></a>
            
            <li><a class="nav-stacked" href="student.php"><i class="fa fa-dashboard fa-fw "></i>  Dashboard</a></li>
            <li class="active"><a class="nav-stacked" href="profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
            <li><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams <?php if($_SESSION['notif']>0) echo "&nbsp;<span class=\"badge pull-right\">".$_SESSION['notif']."</span>";?></a></li>
            <li><a class="nav-stacked" href="my_groups.php"><i class="fa fa-users fa-fw"></i>My Groups</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user col-md-10">
      <div class="alert alert-success alert-dismissable" hidden>
          <a class="close" data-dismiss="alert" aria-hidden="true" >&times;</a>
          <strong>Success!</strong> Your message has been sent successfully.
      </div>
   
        <center>
          <div class="page-header"><h2><strong> My Profile</strong></h2></div>
         </center>
      <form name="userProfile" method="post"  enctype="multipart/form-data">
          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">First Name</span>
             <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $row['firstname'];?>" maxlength="30" disabled="disabled" />
              <span class="input-group-addon">Last Name</span>
             <input type="text" name="lastname" id="lastname" class="form-control" value=<?php echo $row['lastname'];?> maxlength="30" disabled="disabled" />
          </div>

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">Username</span>
             <input type="text" name="username" id="username" class="form-control" value=<?php echo $row['username'];?> maxlength="30" disabled="disabled" />
          </div>

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">Student No.</span>
             <input type="text" name="studentNo" id="studentNo" class="form-control" value=<?php echo $row['studentNo'];?> maxlength="10" readonly/>
          </div> 

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">New Password</span>
             <input type="password" name="newPassword" id="newPassword" class="form-control" value="" maxlength="30" disabled="disabled" />
          </div> 

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">Account Type</span>
             <input type="text" id="accountType" class="form-control" value="Student" disabled="disabled" />
          </div> 

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">E-mail</span>
             <input type="email" name="email" id="email" class="form-control" value=<?php echo $row['email'];?> maxlength="30" disabled="disabled" />
          </div> 

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">Profile Picture</span>
             <input type="file" name="profPic" id="profpic" accept="image/*" class="form-control"  disabled="disabled" />
          </div> 

          <div class="form-group input-group" id="stud-input" >
             <span class="input-group-addon">Enter Current Password</span>
             <input type="password" name="currPassword" id="currPassword" class="form-control" value="" maxlength="30" disabled="disabled" required/>
          </div> 
          <br><br>
          <div class="modal-footer">
             <button id="editProfile" name="edit" type="button" class="btn btn-danger"><i class="fa fa-edit"></i> Edit</button>
             <button name="save" id="savebtn" type="submit" class="btn btn-info" disabled="disabled"><i class="fa fa-save"></i> Save</button>
          </div>
       
      </form>
       
        

    
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