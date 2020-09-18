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
    <title>存款</title>
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
        #controlGroup{
            margin-bottom: 5px;
        }
        #detailDate{
            padding: 7px;
        }
        .action{
           padding: 5px;
           font-size: 20px;
        }
        #ActionAmount{
            text-align: right;
        }
        #btnClearAmount{
            height: 36px;
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
        .btn-detail{
            width:80px;
        }
        .note{
            color: grey ;
        }
        

    </style>
</head>
<body>
    <div class="container">
      <!-- Content here -->
      <?php require_once("navBar.php")?>
      <!-- main view -->
      <div id = "balanceBlock" >
          <div id="titlebalace" class="row justify-content-center title-s">
              <div class="col" style="text-align:center">帳戶餘額</div>
          </div>
          <div id="balanceShow" class="row justify-content-center title-s">
              <div id="balanceStar" class="col-4 justify-content-center" style="text-align:right">$*******</div>
              <div id="balanceNum" class="col-4 justify-content-center hide" style="text-align:right"></div>
              <div id="blanceEye" class="col-2">
                  <i id = "eye" class="fa fa-eye " aria-hidden="true" onclick="eyeShow(1)"></i>
                  <i id = "eyeHide"class="fa fa-eye-slash hide" aria-hidden="true" onclick="eyeShow(0)"></i>
              </div>
          </div>
      </div>
      <hr>
      <!-- 存款 -->
      <div id="titlebalace" class="row justify-content-center title-s">
        <div class="col" style="text-align:center">存款</div>
      </div>
      <div class="row justify-content-center">
        <div class = "col-6">
            <div class="input-group mb-3">
                <input id = "inputAmount" type="number" min="100" class="form-control" placeholder="輸入金額" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
        </div>
            <input id="btnClearAmount" type="button" class="btn btn-outline-secondary col-2" value="清空"></input>
      </div>
      <div class="row justify-content-center">
        <input id="btnDeposit" type="submit" class="btn btn-outline-info col-4" value="確認"></input>
        <input id="btnCancel" type="button" class="btn btn-outline-secondary col-4" value="取消"
               onclick="window.location.href='main.php'"></input>
      </div>
      <!-- dialog -->
      <?php require_once("modal.php")?>
      

    <script>
        let balance = 0;
        $(function(){
            let userInfo;
            $.ajax({
                type:"POST",
                url:"API/api.php?url=getBalance"
            }).then(function(e){
                userInfo=JSON.parse(e);
                $("#navBarUserName").append(userInfo["uName"]);
                $("#balanceNum").text("$"+userInfo["uBalance"]);
                
            })
            $("#btnClearAmount").click(clearAmount);
            $("#btnDeposit").click(deposit);

            function deposit(){
                let dataDep =  {
                    userId: userInfo["uId"],
                    transName: "存款",
                    amount: $("#inputAmount").val()
                }
                $.ajax({
                    type:"POST",
                    url:"API/api.php?url=deposit",
                    data: dataDep,
                    success:function(e){
                        // console.log(JSON.parse(e));
                        setModal("交易信息",e);
                    },
                    error:(function(e){
                        console.log(e);
                    })
                })
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
            // function logout(){
            //     $.ajax({
            //     type:"POST",
            //     url:"api/logout"
            //     }).then(function(e){
            //         console.log(e);
            //         if(e==1){
            //             window.location.href="login.php"
            //         }else{
                        
            //         }
            //     })
            // }
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
        function clearAmount(){
            $("#inputAmount").val("");
        }
        function logout(){
            $.ajax({
            type:"POST",
            url:"api/logout"
            }).then(function(e){
                console.log(e);
                if(e==1){
                    window.location.href="login.php"
                }else{
                    
                }
            })
        }
        function setModal(title,content){
            $(".modal-title").text(title);
            $(".modal-body").html(content);
            $("#btnModalClose").click(function(){
                window.location.reload();
            })
            $(".modal").modal();
        }
        
        
    </script>
</body>
</html>
