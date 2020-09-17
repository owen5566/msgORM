<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
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
        #submit{
            margin:6px;
        }
        .pass{
            color:green
        }
        .error{
            color:red
        }
    </style>
</head>
<body>
    <div class="container">
      <!-- Content here -->
      <div id = "title"class="row"><div>歡迎</div></div>
      <!-- sign up Input -->
      <div class="row" style="margin: 20px;">
          <div class = "col" >
            <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;">註冊</div>
                <form method = "POST">
                <div class="form-group row">
                    <label class="col-4 col-form-label" for="sTxtAccountName">帳戶名稱</label> 
                    <div class="col-8">
                    <input id="sTxtAccountName" name="sTxtAccountName" type="text" class="form-control" required>
                    <div id="checkAccountName" class="" style="font-size: xx-small;"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtPass" class="col-4 col-form-label">密碼</label> 
                    <div class="col-8">
                    <input id="sTxtPass" name="sTxtPass" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtPass2" class="col-4 col-form-label">再次確認密碼</label> 
                    <div class="col-8">
                    <input id="sTxtPass2" name="sTxtPass2" placeholder="" type="password" class="form-control" aria-describedby="text2HelpBlock" required> 
                    <div id="passHelpBlock" class="" style="color: crimson; font-size: xx-small;"><i class="fa fa-close fa-1"></i>請確認兩次輸入是否相同</div>
                    <div id="passHelpBlock2" class="" style="color: green; font-size: xx-small;"><i class="fa fa-check fa-1" aria-hidden="true"></i>正確</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtName" class="col-4 col-form-label">姓名</label> 
                    <div class="col-8">
                    <div class="input-group">
                        <input id="sTxtName" name="sTxtName" type="text" class="form-control" required> 
                        <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                        </div>
                    </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="sTxtBirth" class="col-4 col-form-label">生日</label> 
                    <div class="col-8">
                    <div class="input-group">
                        <input id="sTxtBirth" name="sTxtBirth" type="date" class="form-control" required> 
                        <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                        </div>
                    </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="sTxtAddress" class="col-4 col-form-label">地址</label> 
                    <div class="col-8">
                    <div class="input-group">
                        <input id="sTxtAddress" name="sTxtAddress" type="text" class="form-control" required> 
                        <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                        </div>
                    </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="sTxtEmail" class="col-4 col-form-label">e-mail</label> 
                    <div class="col-8">
                    <div class="input-group">
                        <input id="sTxtEmail" name="sTxtEmail" type="text" class="form-control" required> 
                        <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                        </div>
                    </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="offset-4 col-8">
                    <button id = "submit" name="submit" type="button" class="btn btn-primary" value=1 disabled>註冊</button>
                    <a href="login.php" style="color: gray;">已經擁有帳戶？登入</a>
                    </div>
                </div>
                </form>
          </div>
          <div class = 'col' style="background-color: antiquewhite;">
      </div>
      <!-- 對話盒 -->
      <div id = "modalSuccess" class="modal fade" tabindex="-1"  role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-delete">
              <h4 class="modal-title modal-delete">messege</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="modalMsg"class="modal-body">
              
            </div>
            <div class="modal-footer">
              <!-- <button id = successModalBtn type="button" class="btn btn-success">確定</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
        let CheckAccount = 0;
        let checkPass = 0;
        $(function(){
            
            $("#passHelpBlock").hide();
            $("#passHelpBlock2").hide();

            $("#sTxtPass2,#sTxtPass").on("blur",function(){
                if($("#sTxtPass2").val()!=$("#sTxtPass").val()||$("#sTxtPass2").val()==""){
                    $("#passHelpBlock").show();
                    $("#passHelpBlock2").hide();
                    // $("#submit").prop("disabled",true);
                    checkPass = 0;
                }else{
                    $("#passHelpBlock").hide();
                    $("#passHelpBlock2").show();
                    // $("#submit").prop("disabled",false);
                    checkPass = 1;
                }
            })
            //檢查全部欄位
            $(".form-control").on("blur",function(){
              let count = 0 ;
              setTimeout(function(){
                  $(".form-control").each(function(){
                    if($.trim($(this).val())!="")
                      count++;
                      if(count==7 && checkPass*CheckAccount==1){
                        $("#submit").prop("disabled",false);
                      }else{
                        $("#submit").prop("disabled",true);
                      }
                  });
              }, 1000);
            })
            //檢查帳號重複
            $("#sTxtAccountName").on("blur",function(){  
                if($.trim($(this).val())!=""){
                    let account = {
                        accountName : $("#sTxtAccountName").val()
                    };
                    $.ajax({
                        type:"post",
                        url:"API/api.php?url=checkAccount",
                        data: account
                    }).then(function(e){
                        console.log(e);
                        if(e==1){
                            $("#checkAccountName").html("<div class='pass'>可使用<div>");
                            CheckAccount = 1;
                        }else{
                            $("#checkAccountName").html("<div class='error'>帳號重複<div>");
                            CheckAccount = 0;
                        }
                    })
                }else{
                   //do nothing 
                }
            })
            //註冊
            $("#submit").click(function(){
                let signUpData = {
                    accountName : $("#sTxtAccountName").val(),
                    userPass : $("#sTxtPass").val(),
                    name : $("#sTxtName").val(),
                    birth : $("#sTxtBirth").val(),
                    address : $("#sTxtAddress").val(),
                    email : $("#sTxtEmail").val()
                };
                //console.log(signUpData);
                $.ajax({
                    type:"post",
                    url:"API/api.php?url=signUp",
                    data:signUpData
                }).then(function(e){
                    console.log(typeof(e),e);
                    if (e=="1") {
                            $("#modalMsg").text("註冊成功！請重新登入");
                            $("#modalSuccess").modal({backdrop: "static"});
                            window.setTimeout(()=>{
                                window.location.href='login.php'
                            },3000)
                    }else{
                        $("#modalMsg").text("(0)註冊失敗！請檢查資料是否正確");
                        $("#modalSuccess").modal({backdrop: "static"});
                    }
                }).catch(function(e){
                    console.log(e);
                    $("#modalMsg").text("(1)註冊失敗！請檢查資料是否正確");
                        $("#modalSuccess").modal({backdrop: "static"});
                })
            })
        })
    </script>
</body>
</html>
