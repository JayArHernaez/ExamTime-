<?php

	session_start();
	include("../db_connect.php");
  $currExam = htmlspecialchars($_GET['view']) ;

  if(isset($_SESSION['role']) && $_SESSION['role'] == 'instructor'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_instructor WHERE employeeNo = '{$_SESSION['empno']}'");
    $row = mysqli_fetch_assoc($fetch);


    $fetchex = mysqli_query($db, "SELECT * FROM tb_exam WHERE employeeNo = '{$_SESSION['empno']}' AND examTitle= '{$currExam}'");
    $resultex = mysqli_fetch_assoc($fetchex);

    $fetchques = mysqli_query($db, "SELECT * FROM tb_question WHERE examID = '{$resultex['examID']}'");
    $resultques = mysqli_fetch_assoc($fetchques);
    $num = mysqli_num_rows($fetchques);

    $startindex = intval($resultques['questionID']);

  }else{
    header("Location: ../index.php");
  }
  

  if (isset($_POST['editExam'])) {
    $try = $_POST['question'];
    $ans = $_POST['answer'];
    $choiceA = $_POST['choicea'];
    $choiceB = $_POST['choiceb'];
    $choiceC = $_POST['choicec'];

     foreach( $try as $key => $qn ) {
          $qn.removeAttribute('readonly');
          $ans[$key].removeAttribute('readonly');
          $ca[$key].removeAttribute('readonly');
          $cb[$key].removeAttribute('readonly');
          $cc[$key].removeAttribute('readonly');
      }

  }
  //save
  if(isset($_POST['save'])){
  $fetch1 = mysqli_query($db, "SELECT * FROM tb_exam WHERE employeeNo = '{$_SESSION['empno']}' AND examTitle= '{$currExam}'");
  $result = mysqli_fetch_assoc($fetch1);

  $fetch = mysqli_query($db, "SELECT * FROM tb_question WHERE examID = '{$result['examID']}'");
  $num = mysqli_num_rows($fetch);
  $rows = mysqli_fetch_assoc($fetch);
      
      $qs = $_POST['question'];
      $ans = $_POST['answer'];
      $ca = $_POST['choicea'];
      $cb = $_POST['choiceb'];
      $cc = $_POST['choicec'];
      $examName = $_POST['examName'];
      

      for($j=0; $j < count($qs);$j++){
        $index = intval($startindex + $j) ; 

        $fetch = mysqli_query($db, "SELECT * FROM tb_question WHERE examID = '{$result['examID']}' AND questionID='{$index}' ");
        $num = mysqli_num_rows($fetch);
        $rows = mysqli_fetch_assoc($fetch);

        $qn = htmlspecialchars($qs[$j]);
        $anskey = htmlspecialchars($ans[$j]);
        $cakey = htmlspecialchars($ca[$j]);
        $cbkey = htmlspecialchars($cb[$j]);
        $cckey = htmlspecialchars($cc[$j]);
        $ename = htmlspecialchars($examName[$j]);
            
        $editQue = mysqli_query($db, "UPDATE tb_question SET question = '{$qn}', ans_key = '{$anskey}', choiceA = '{$cakey}',
                choiceB = '{$cbkey}', choiceC = '{$cckey}' WHERE questionID = '{$index}'");
      }

      $examn = htmlspecialchars($_POST['examName']);
      $examtakers = htmlspecialchars($_POST['examTakers']);
      $examdate = htmlspecialchars($_POST['examDate']);
      $timeallot = $_POST['examTime'];

      $hh = floor($timeallot/60);
      $mm = (int)$timeallot%60;
      $tme = $hh.":".$mm.":00";


      $updateexam = mysqli_query($db, "UPDATE tb_exam SET examTitle = '{$examn}', examTakers = '{$examtakers}', examDate = '{$examdate}',
                timeAlloted = '{$tme}' WHERE employeeNo = '{$_SESSION['empno']}' AND examID = '{$result['examID']}'");

      
      //assign student to take the exam
       $fech2 = mysqli_query($db, "SELECT studentNo FROM tb_in_group WHERE groupname = '{$examtakers}'");
       $numr = mysqli_num_rows($fech2);

       
       //update to tb_assign_exam
       for ($i=0; $i < $numr ; $i++) { 
          $res = mysqli_fetch_assoc($fech2);
          $fech3 = mysqli_query($db, "UPDATE tb_assign_exam SET status = 1 WHERE studentNo='{$res['studentNo']}' AND examID='{$result['examID']}')");
        } 

      echo "<script>alert(\"Exam Successfully Edited!\")</script>";
      header("Location: view_exam.php?view=".$examName);

    
  }//if

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
            <li class="active"><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams</a></li>
            <li><a class="nav-stacked" href="my_students.php"><i class="fa fa-users fa-fw"></i> My Students</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Create exam form
          
    -->
    <div class="jumbotron">
      <div class="container_user">
         <a href="my_exams.php"><button class="btn btn-danger"><i class="fa fa-chevron-circle-left"></i> Back</button></a><br/><br/>
        <div class="panel panel-success">
           <div class="panel-heading">
              <h3 class="panel-title"><strong>View Exam</strong></h3>
           </div>
           <div class="panel-body">
           <div class="alert alert-info" role="alert">
              Hello you can also create changes on this exam. :)
            </div>
              <form role="form" method="post" id="edit-exam-form">
                <?php
                  $fetch = mysqli_query($db, "SELECT * FROM tb_exam WHERE employeeNo = '{$_SESSION['empno']}' AND examTitle= '{$currExam}'");

                     $result = mysqli_fetch_assoc($fetch);
                  
                ?>
                    <div class="form-group input-group">
                        <span class="input-group-addon">Exam Name</span>
                        <input name="examName" id="examname" type="text" class="form-control" maxlength="30" value="<?=$result['examTitle']?>" disabled="disabled"  required/>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon">Exam Takers</span>
                        <select name="examTakers" id="examtakes" class="form-control" disabled required/>
                         <!--  <option value="ect" selected>Exam Takers</option> -->
                            <?php 
                                $grpno = mysqli_query($db, "SELECT * FROM tb_group WHERE employeeNo = '{$_SESSION['empno']}'");
                                $num_r = mysqli_num_rows($grpno);

                                for ($i=0; $i < $num_r; $i++) { 
                                  $row = mysqli_fetch_assoc($grpno);
                                  //var_dump($row);
                            ?>
                                    <option value="<?=$row['groupname']?>" <?php if($row['groupname']==$result['examTakers'])echo "selected"; ?> ><?=$row['groupname']?>
                                    </option>
                            <?php
                                }
                                
                            ?>
                          </select>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon">Exam Date</span>
                        <input name="examDate" id="examdate" type="date" class="form-control" min=<?=date("Y-m-d") ?> value="<?=$result['examDate']?>" disabled="disabled" required/>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon">Time Allotted (minutes)</span>
                        <input name="examTime" id="examtime" type="number" class="form-control" min="1" value="<?php
                          $tme = date_parse($result['timeAlloted']);
                          $compute = $tme['hour']*60+$tme['minute'];
                          echo "$compute";
                         ?>" disabled="disabled"  required/>
                    </div>

                    <hr style="border-style: inset;border-width: 1px"/>
                    <div>
                      <label>Questions:</label><br>
                      <!--button name="addQuestion" id="addQuestion-btn" class="btn btn-warning" disabled="disabled">Add Question</button-->
                      
                    </div>
                    <?php 
                        $fetch1 = mysqli_query($db, "SELECT * FROM tb_question WHERE examID = '{$result['examID']}'");
                        $num_r = mysqli_num_rows($fetch1);

                        for ($i=0; $i < $num_r; $i++) { 
                          $row = mysqli_fetch_assoc($fetch1);
                          //var_dump($row);
                    ?>
                    <div class="panel-body " >
                      <div class="question-group">
                        <div class="input-group">
                          <span class="input-group-addon">Q<?=$i+1?></span>
                          <input name="question[]" id="" type="text" class="form-control" value="<?=$row['question']?>"readonly />
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">Answer</span>
                          <input name="answer[]" id="" type="text" class="form-control" value="<?=$row['ans_key']?>"readonly/>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">Other Choices</span>
                          <input name="choicea[]" id="" type="text" class="form-control" value="<?=$row['choiceA']?>"readonly/>
                          <input name="choiceb[]" id="" type="text" class="form-control" value="<?=$row['choiceB']?>"readonly/>
                          <input name="choicec[]" id="" type="text" class="form-control" value="<?=$row['choiceC']?>"readonly/>
                        </div>
                      </div>
                    </div>
                    <?php
                        }//forloop
                    ?>
                    </div>
                    <br>
                    
                      <center>
                        <button name="editExam" id ="editexam" type="button" class="btn btn-danger"><i class="fa fa-edit"></i> Edit this Exam!</button>
                        <button name="save" id ="saveexam" type="submit" class="btn btn-info" disabled><i class="fa fa-save"></i> Save</button>
                      </center>
                    
              </form>
           </div>
        </div>

        
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
