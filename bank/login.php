<?php 
    session_start();
    if(!isset($_SESSION["userId"])){
       
    }else{
        header("location: main.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }
        #title-s{
            font-size: xx-large;
            color: grey ;
            margin-bottom: 10px;
        }
        #inputRow{
            margin: 20px;
        }
        #signUp{
            margin:6px;
        }
        .error{
            color:red;
            display: none;
        }        
    </style>
</head>
<body>
    <div class="container" >
        <!-- Content here -->
        <div id = "title"class="row"><div>歡迎</div></div>
        <!-- loginInput -->
        <div id="inputRow" class="row">
            <div class="col">
                <div id="title-s">登入</div>
                    <!-- username -->
                    <div class="input-group mb-3 col-6">
                        <input id = "txtUserName" type="text" name="txtUserName" class="form-control" placeholder="使用者帳戶" aria-label="Username"
                            aria-describedby="basic-addon1" required>
                    </div>
                    <!-- password -->
                    <div class="input-group mb-3 col-6">
                        <input id = "txtUserPass" type="password" name="txtUserPass" class="form-control" placeholder="密碼" aria-label="Username"
                            aria-describedby="basic-addon1" required>
                    </div>
                    <div id="errorMsg" class="input-group mb-3 col-6 error" >帳號／密碼錯誤</div>
                    <div id="errorMsg2" class="input-group mb-3 col-6 error" >請輸入帳號／密碼</div>

                    <div class="row" >
                        <input id = "btnLogin" type="submit" name="btnLogin" value="登入" class="btn btn-outline-success col-1.5"></input>
                        <div id="signUp">還沒有帳戶?<a href="signUp.php">新帳戶註冊</a></div>
                    </div>
            </div>
            </div>
    </div>

    <script>
        $(function(){
             $("#btnLogin").click(function(){
                let count = 0;
                $("#errorMsg").hide();

                $(".form-control").each(function () {
                    if ($.trim($(this).val()) != "")
                        count++;
                })
                if(count!=2){
                    $("#errorMsg2").show();
                    return 0;
                }
                $("#errorMsg2").hide();
                let loginData = {
                    userName : $("#txtUserName").val(),
                    userPass : $("#txtUserPass").val()
                }
                $.ajax({
                    type: "POST",
                    url: "API/api.php?url=login",
                    data: loginData
                }).then(function(e){
                    console.log(e);
                    if(e==1){
                        window.location.href="main.php"
                    }else{
                        $("#errorMsg").show();
                    }
                })
            })
        })
    </script>
</body>
</html>
