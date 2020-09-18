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
    <title>detail</title>
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
            background-color: whitesmoke;
        }
        .action{
           padding: 5px;
           font-size: 20px;
        }
        #ActionAmount{
            text-align: right;
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
        #detailSum{
            margin: 5px;
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
              <div id="balanceStar" class="col-4" style="text-align:right">$*******</div>
              <div id="balanceNum" class="col-4 justify-content-center hide" style="text-align:right"></div>
              <div id="blanceEye" class="col-2">
                  <i id = "eye" class="fa fa-eye " aria-hidden="true" onclick="eyeShow(1)"></i>
                  <i id = "eyeHide"class="fa fa-eye-slash hide" aria-hidden="true" onclick="eyeShow(0)"></i>
              </div>
          </div>
      </div>
      <hr>
      <!-- button Group -->
      
      <div id="controlGroup" class="row justify-content-center">
        <div class="btn-group btn-group-toggle row justify-content-center" data-toggle="buttons">
            <label id = "" class="radioOp btn btn-outline-success active" data-day="1">
              <input type="radio" name="options" id="dOption" autocomplete="off" checked> 今天
            </label>
            <label id = "" class="radioOp btn btn-outline-success" data-day="7">
              <input type="radio" name="options" id="dOption" autocomplete="off"> 近七天
            </label>
            <label id = "" class="radioOp btn btn-outline-success" data-day="30">
              <input type="radio" name="options" id="dOption" autocomplete="off"> 近一個月
            </label>
            <label id = "" class="radioOp btn btn-outline-success" data-day="99999">
              <input type="radio" name="options" id="dOption" autocomplete="off"> 全部時間
            </label>
          </div>
        <!-- <div id = "btnGroup" class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-success btn-detail">今天</button>
            <button type="button" class="btn btn-outline-success btn-detail">這週</button>
            <button type="button" class="btn btn-outline-success btn-detail">這個月</button>
        </div> -->
      </div>
      <!-- detail list -->
      <div id="detailList" >
      </div>
      <div id="detailSum">
        <div id = "sumIn" class="row justify-content-center"></div>
        <div id = "sumOut" class="row justify-content-center"></div>

      </div>
    <!-- total -->

    <script>
        let balance = 0;
        
        $(function(){
            let userInfo;
            let record;
            let today = new Date();
            $.ajax({
                type:"POST",
                url:"API/api.php?url=getBalance"
            }).then(function(e){
                userInfo=JSON.parse(e);
                $("#navBarUserName").append(userInfo["uName"]);
                $("#balanceNum").text("$"+userInfo["uBalance"]);
                
            })
            $.ajax({
                type:"POST",
                url:"API/api.php?url=getRecord"
            }).then(function(e){
                record=JSON.parse(e);
                console.log(record);
                
                
                let rDay = new Date("2020-09-01 01:24:33");
                console.log(rDay.getFullYear());
                showDetails(record, today, 1);
                
            })
            $(".radioOp").click(function(){
                showDetails(record,today,($(this).data("day")))
            })
        })
        function showDetails(obj,time,daysAgo){
                $("#detailList").html("");
                let countIn=0;
                let countOut=0;
                let sumIn=0;
                let sumOut=0;
                const oneDay = 1000*60*60*24;
                obj.forEach(element => {
                    let tDate = new Date(element["transDate"]);
                    let mark = "";
                    if((time-tDate)/oneDay>daysAgo){
                        return true;
                    }
                    if(element["transMode"]==1) { 
                        mark="+";
                        sumIn+=parseInt(element["transAmount"]);
                        countIn++; 
                    }else{ 
                        mark="-";
                        sumOut+=parseInt(element["transAmount"]);
                        countOut++;
                    }
                    $("#detailList").append(
                        $("<div id ='detail'/>")
                        .addClass('row')
                        .html(
                            $("<div/>").addClass("col")
                            .html(
                                $("<div id = detailDate/>")
                                .addClass('row')
                                .text((element["transDate"]))
                            ).append(
                                $("<div id ='detailAction'/>")
                                .addClass('row action')
                                .html(
                                    $("<div id='ActionName'/>")
                                    .addClass('col action')
                                    .text(element["transName"])
                                ).append(
                                    $("<div id='ActionAmount'/>")
                                    .addClass('col action')
                                    .text(mark+"$"+element["transAmount"])
                                )
                            ).append(
                                $("<div id ='detailAction'/>")
                                .addClass('row')
                                .html(
                                    $("<div id='ActionName'/>")
                                    .addClass('col note')
                                    .text("備註: "+((element["transNote"]) ? element["transNote"]:""))
                                ).append(
                                    $("<div id='ActionAmount'/>")
                                    .addClass('col note')
                                    .text("餘額$"+element['transBalance'])
                                )
                            )
                        )
                    ).append($("<hr>"));    
                });
                $("#sumIn").html("存入 " +countIn + " 筆, 共計$" + sumIn);
                $("#sumOut").html("提出 " +countOut + " 筆, 共計$" + sumOut);
        }
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
