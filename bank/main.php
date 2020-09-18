<?php
    session_start();
    if(isset($_SESSION["userId"])){
        $userId = $_SESSION["userId"];
        $userName = $_SESSION["userName"];
    }else{
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>
    <link rel="stylesheet" href="css/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="css/bootstrap4/popper.js"></script>
    <script src="css/bootstrap4/bootstrap.min.js"></script>
    <style>
        #title{
            color: white;
            font-size: xx-large;
            background-color: #28a745;
            padding: 10px;
            margin-bottom: 10px;
        }
        .title-s{
            font-size: xx-large;
            color: grey ;
        }
        .btn{
            margin: 2px;
        }
        .hide{
            display:none;
        }
    </style>
</head>
<body>
    <div class="container">
      <!-- Content here -->
      <?php require("navBar.php")?>
      <!-- <div id = "title" class="row">
          <div class="col">歡迎</div>
          <div class="col" style="text-align:right"><button type="button" class="btn btn-light">登出</button></div>
      </div> -->
      <!-- main view -->
      <div id = "balanceBlock" >
          <div id="titlebalace" class="row justify-content-center title-s">帳戶餘額</div>
          <div id="balanceShow" class="row justify-content-center title-s">
              <div id="balanceStar" class="col-4 justify-content-center" style="text-align:right">$*******</div>
              <div id="balanceNum" class="col-4 justify-content-center hide" style="text-align:right"></div>

              <div id="balanceEye" class="col-2">
                  <i id = "eye" class="fa fa-eye " aria-hidden="true" onclick="eyeShow(1)"></i>
                  <i id = "eyeHide"class="fa fa-eye-slash hide" aria-hidden="true" onclick="eyeShow(0)"></i>
              </div>
          </div>
      </div>
      <div id="controlGroup" class="row justify-content-center">
        <button type="button" class="btn btn-outline-success" onclick="window.location.href='withdraw.php'">提款</button>
        <button type="button" class="btn btn-outline-success" onclick="window.location.href='deposit.php'">存款</button>
        <a href="detail.php">
            <button type="button" class="btn btn-outline-success">查看明細</button>
        </a>
        <button type="button" class="btn btn-outline-secondary">帳戶資訊</button>
      </div>
    <script>
        let balance = 0;
        $(function(){
            $.ajax({
                type:"POST",
                url:"API/api.php?url=getBalance"
            }).then(function(e){
                let data=JSON.parse(e);
                $("#navBarUserName").append(data["uName"]);
                $("#balanceNum").text("$"+data["uBalance"]);
            })
        })
        function eyeShow(status){
            if(status){
                $("#eyeHide").show();
                $("#eye").hide();
                $("#balanceNum").show();
                $("#balanceStar").hide();

            }else{
                $("#eyeHide").hide();
                $("#eye").show();
                $("#balanceNum").hide();
                $("#balanceStar").show();

            }
        }
        function logout(){
            $.ajax({
            type:"POST",
            url:"API/api.php?url=logout"
            }).then(function(e){
                console.log(e);
                if(e==1){
                    window.location.href="login.php"
                }else{
                    
                }
            })
      }
    </script>
</body>
</html>
