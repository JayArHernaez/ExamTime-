<?php
	session_start();
	include("../db_connect.php");
	
  if(isset($_SESSION['role']) && $_SESSION['role'] == 'student'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '{$_SESSION['username']}'");
    $row = mysqli_fetch_assoc($fetch);
    
    $_SESSION['setEx'] = 1;

    $examtitle = base64_decode(base64_decode($_GET['qAz'])) ;
    $examid = base64_decode($_GET['RgBjI']);

     $u1 = mysqli_query($db, "SELECT DISTINCT examID FROM tb_assign_exam WHERE studentNo = '{$_SESSION['studno']}' AND status = '1'");
      $u2 = mysqli_num_rows($u1);
      $_SESSION['notif'] = $u2;

    $f2 = mysqli_query($db, "SELECT timeAlloted FROM tb_exam WHERE examID = '{$examid}' AND examTitle = '{$examtitle}' ");
    $r2 = mysqli_fetch_assoc($f2);

    $score = 0;

	}else{
		header("Location: ../index.php");
	}

  if(isset($_POST['nowYouSeeMe'])){
    //echo "<script>alert('Wooo')</script>";

    $numberOf = $_POST['hidden'];
    $sequence = explode(",",$_POST['shytype']);
    //print_r($sequence);

    $arrayAns = array();
    for($i=0; $i < intval($numberOf); $i++){
      if(!isset($_POST['options'.$i])){
        array_push($arrayAns,"No Answer" );
      }else{
        //print_r($_POST['options'.$i][0]);
        array_push($arrayAns, "".htmlspecialchars($_POST['options'.$i][0])."" );
      }
    }

    
    //print_r($_POST);
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
           <a href="../logout.php"> <button class="btn btn-success"><i class="fa fa-sign-out"></i> Log Out</button></a>
			
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
          <!---->
          <form method="post">
            <center></center>  
          </form>

              <br/><br/> 

              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h2 class="">Alright!</h2>
                </div>
             

              <div class="panel-body"> 
                <div class="alert alert-info" role="alert">
                  Hello! How's the exam? :)
                </div>
                <div class="panel-body two-col">
                     
                  <?php 
                    if($_SESSION['setEx']==1){

                    //  var_dump(sizeof($sequence)."\n");
                      for($j=0; $j < sizeof($sequence); $j++){
                         $ff = mysqli_query($db, "SELECT * from tb_question where questionID = '{$sequence[$j]}'AND examID = '{$examid}'");
                        $fff = mysqli_fetch_assoc($ff);
                      
                  ?>
                        <div class="row">
                            <center>
                            <p><?=$fff['question']?></p>


                            <?php
                              $mychoices = array($fff['ans_key'],$fff['choiceA'],$fff['choiceB'],$fff['choiceC']);
                              shuffle($mychoices);

                            ?>
                            
                            <div class="btn-group" data-toggle="buttons">     
                              <?php
                                for ($i=0; $i < 4; $i++) { 
                                  ?>
                                    <label class="btn btn-primary">
                                      <input type="radio" name="options[]" id="<?="option".$i?>" autocomplete="off" value="<?=$mychoices[$i]?>" disabled><?=$mychoices[$i]?></input>
                                    </label>
                                  <?php
                                }
                              ?>
                              <br> <br>
                              <label> Correct Answer: </label>
                              <input type="text" name="hidden[]" value="<?=$fff['ans_key']?>" style="text-align:center;background-color:#0C6;color:white" readonly></input><br>
                              <label> Your Answer: </label>
                              
                              <?php
                              $string = "<input type='text' name='hidden[]' value='".$arrayAns[$j]."' style='text-align:center;background-color:";
                                if($fff['ans_key']==$arrayAns[$j]){
                                  $score++;
                                  $string = $string."#0C6";
                                }else $string = $string."red";
        
                                $string = $string.";color:white' readonly></input>";
                                echo $string;
                              ?>

                            </div>
                            
                            </center>
                            
                          </div> <br>
                <?php             
                  }//forloop
                }//if
              ?>
               <div class="panel panel-info">
                  <h2 class="pull-right">Your Score: <?=$score?></h2>
                </div>         
                            
               <?php
                    $upd = mysqli_query($db, "UPDATE tb_assign_exam set result={$score} where studentNo = '{$_SESSION['studno']}' and examID = '{$examid}'");

               ?>      

          
                

          </div>
        </div>
      </div>
        <center>
          <a href="my_exams.php"><button class="btn btn-success" type="submit">Exit Now</button></a>
          <a href="print.php"><button class="btn btn-warning" type="button">Download</button></a>
        </center>
        
        <br><br>
		
     
        <?php $_SESSION['setEx']=0;?>
   
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
