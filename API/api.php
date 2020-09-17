<?php

$method = $_SERVER['REQUEST_METHOD'];
rtrim($_GET["url"], "/")."<hr>"; 
$url = explode("/", rtrim($_GET["url"], "/"));
//設定資料庫連線
$db = new PDO("mysql:host=127.0.0.1;dbname=RD5_db;port=3306", "root", "");
$db->exec("set names utf8");
switch ($method." ".$url[0]) {
    case 'POST signUp':
        echo signUp();
        break;
    case 'POST checkAccount':
        echo checkAccount($_POST["accountName"]);
        break;
    case 'POST login':
        echo (login());
        break;
    case 'POST getBalance':
        echo getBalance();
        break;
    case 'POST logout':
        echo logout();
        break;
    case 'POST deposit':
        echo (deposit());
        break;
    case 'POST withdraw':
        echo (withdraw());
        break;
    case 'POST getRecord':
        echo json_encode(getRecord());
        break;
    default:
        # code...
        break;
}
function checkAccount($account){
    global $db;
    $sqlCheckAccount = $db->prepare("select uAccountName from users where uAccountName=:accountName");
    $sqlCheckAccount->bindParam("accountName", $account, PDO::PARAM_STR);
        if ($sqlCheckAccount->execute()) {
            if (!$result = $sqlCheckAccount->fetch()) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return "query account error";
        }
}
function signUp(){
    global $db;
    if (checkAccount($_POST["accountName"])){
        $accountName = $_POST["accountName"];
        $userPass = $_POST["userPass"];
        $userPass = hash("sha256",$userPass);
        $name = $_POST["name"];
        $birth = $_POST["birth"];
        $address = $_POST["address"];
        $email = $_POST["email"];
        $sqlSignUp = $db->prepare("INSERT INTO `users` (`uAccountName`, `uPass`, `uName`, `uBirth`, `uAddress`, `uEmail`) 
                                   VALUES (:accountName, :userPass, :name, :birth, :address, :email)");
        $sqlSignUp->bindParam("accountName", $accountName, PDO::PARAM_STR);
        $sqlSignUp->bindParam("userPass", $userPass, PDO::PARAM_STR);
        $sqlSignUp->bindParam("name", $name, PDO::PARAM_STR);
        $sqlSignUp->bindParam("birth", $birth, PDO::PARAM_STR);
        $sqlSignUp->bindParam("address", $address, PDO::PARAM_STR);
        $sqlSignUp->bindParam("email", $email, PDO::PARAM_STR);
        if($sqlSignUp->execute()){
            return 1;
        }else{
            return 0;
        }
    }else{
        return "repeat";
    }	
}
function login(){
    global $db;
    $userAccount = $_POST["userName"];
    $userPass = $_POST["userPass"];
    $sqlLogin = $db->prepare("select uId,uAccountName,uPass from users where uAccountName=:accountName");
    $sqlLogin->bindParam("accountName",$userAccount,PDO::PARAM_STR);
    if($sqlLogin->execute()){
        if($row = $sqlLogin->fetch()){
            if (hash("sha256",$userPass)==$row["uPass"]) {
                session_start();
                $_SESSION['userId']=$row["uId"];
                $_SESSION['userName']=$row["uAccountName"];
                return 1;
            }
        }
    }
    return 0;
}
function logout(){
    session_start();
    return session_unset();
    
}
function getBalance(){
    global $db;
    session_start();
    if(isset($_SESSION["userId"])){
        $uId = $_SESSION["userId"];
        $result = $db->query("select uId , uName, uBalance from users where uId = $uId");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return json_encode($row);
    }else{
        return "login required";
    }
}
function deposit(){
    global $db;
    date_default_timezone_set("Asia/Taipei");

    if(isset($_POST["userId"])&&isset($_POST["amount"])){
        $uId = $_POST["userId"];
        $amount=$_POST["amount"];
        if(!checkAmount($amount)){
            return "請輸入正確金額";
        }
        $transName = $_POST["transName"];
        $transDate = date("Y-m-d H:i:s");  
        $transUId = (isset($_POST["transUId"])) ? $_POST["transUId"] : "null";
        $transNote = (isset($_POST["transNote"])) ? $_POST["transNote"] : "null";
        // return json_encode([$uId,$transName,$transDate,$transNote,$transUId,$amount]);
        $db->beginTransaction();
        $sql = "update users set uBalance = uBalance + $amount where uId= $uId;";
        if(!$result = $db->query($sql)){
            $db->rollback();
            return "balance error";
        }
        $sql = " select uBalance from users where uId = $uId;";
        if(!$result = $db->query($sql)){
            $db->rollback();
            return "query balance error";
        }
        $row = $result->fetch();
        $transBalance = $row[0];
        $sql = "INSERT INTO `transactions`( `uId`, `transMode`, `transName`, `transDate`, `transUId`, `transAmount`, `transNote`,`transBalance`) VALUES ($uId, 1 ,'$transName','$transDate',$transUId,$amount,$transNote,$transBalance)";
        if(!$db->query($sql))
        {
            $db->rollback();
            return $db->errorInfo();                                     
        }
        $db->commit();
        return "交易成功";
    }
}
function withdraw(){
    global $db;
    date_default_timezone_set("Asia/Taipei");

    if(isset($_POST["userId"])&&isset($_POST["amount"])){
        $uId = $_POST["userId"];

        $sql = " select uBalance from users where uId = $uId;";
        if(!$result = $db->query($sql)){
            $db->rollback();
            return "query balance error";
        }
        $row = $result->fetch();
        $balance = $row[0];
        if((    $amount = $_POST["amount"])<1){
            return "輸入金額錯誤";
        }
        if($amount >$balance){
            return "可憐吶 餘額不足";
        }

        $transName = $_POST["transName"];
        $transDate = date("Y-m-d H:i:s");  
        $transUId = (isset($_POST["transUId"])) ? $_POST["transUId"] : "null";
        $transNote = (isset($_POST["transNote"])) ? $_POST["transNote"] : "null";
        
        // return json_encode([$uId,$transName,$transDate,$transNote,$transUId,$amount]);
        $db->beginTransaction();
        $sqlUpdate = "update users set uBalance = uBalance - $amount where uId= $uId;";
        if(!$result = $db->query($sqlUpdate)){
            $db->rollback();
            return "balance error";
        }
        if(!$result = $db->query($sql)){
            $db->rollback();
            return "query balance error";
        }
        $row = $result->fetch();
        $transBalance = $row[0];
        $sql = "INSERT INTO `transactions`( `uId`, `transMode`, `transName`, `transDate`, `transUId`, `transAmount`, `transNote`,`transBalance`) VALUES ($uId, '0' ,'$transName','$transDate',$transUId,$amount,$transNote,$transBalance)";
        if(!$db->query($sql))
        {
            $db->rollback();
            return $db->errorInfo();                                     
        }
        $db->commit();
        return "交易成功";
    }
}
function getRecord(){
    global $db;
    session_start();
    $dataToClient = array();
    $uId = $_SESSION["userId"];
    $sql = "select * from transactions where uId=$uId order by transDate DESC";
    $result = $db->query($sql);
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $dataToClient[] = $row;
    }
    return $dataToClient;
}
function checkAmount($num){
    if (preg_match("/[^0-9]/",$num)||$num=="") {
        return false;
    }
    return true;
}

// $method = $_SERVER['REQUEST_METHOD'];
// echo rtrim($_GET["url"], "/")."<hr>"; 
// $url = explode("/", rtrim($_GET["url"], "/") );

// echo $url;

// $dblink = mysqli_connect("localhost","root","root")or die(mysqli_connect_error());
// mysqli_query($dblink,"set names utf8");
// mysqli_select_db($dblink,"apiDB");

// switch ($method . " " . $url[0]) {
//     case "POST products":
//         insertProduct();
//         break;
//     case "GET products":
//         if (isset($url[1]))
//             getProductById($url[1]);
//         else
//             getProducts();
//         break;
//     case "PUT products":
//         updateProduct($url[1]);
//         break;
//     case "DELETE products":
//         deleteProduct($url[1]);
//         break;
//     default:
//         echo "Thank you";
// }
// mysqli_close($dblink);

// function getProductById($id) {
//     if (!is_numeric($id))
//     	die( "id is not a number." );

//     global $dblink;
//     $result = mysqli_query($dblink, 
//       "select * from products where productId = " . $id );
//     $row = mysqli_fetch_assoc($result);
//     echo json_encode($row);
// }

// function getProducts() {
//     global $dblink;
//     $result = mysqli_query($dblink, 
//       "select * from products");
//     while ($row = mysqli_fetch_assoc($result)) {
//         $dataList[] = $row;
//     }echo(json_encode($dataList));
// }

// function insertProduct() {
//     global $dblink;
    
//     $productName = $_POST["productName"];
//     $price       = $_POST["price"];
//     $quantity    = $_POST["quantity"];
//     $commandText = 
//         "insert into products "
//       . "set productName = '{$productName}' "
//       . "  , price       = '{$price}'"
//       . "  , quantity    = '{$quantity}'";
//     $result = mysqli_query($dblink, $commandText); 
    
//     echo $result;
// }


// function updateProduct($id) {
//     if (! isset ( $id ))
//     	die ( "Parameter id not found." );
//     if (! is_numeric ( $id ))
//         die ( "id not a number." );

//     global $dblink;
    
//     parse_str(file_get_contents('php://input'), $putData);
//     //echo json_encode($putData);
//     //return;
//     $productName = $putData["productName"];
//     $price       = $putData["price"];
//     $quantity    = $putData["quantity"];
//     $commandText = 
//         "update products "
//       . "set productName = '{$productName}' "
//       . "  , price       = '{$price}'"
//       . "  , quantity    = '{$quantity}'"
//       . "  where productId = {$id}";
//     mysqli_query($dblink, $commandText); 
    
//     echo "Updated: " . $id;
// }


// function deleteProduct($id) {
//     if (! isset ( $id ))
//     	die ( "Parameter id not found." );
//     if (! is_numeric ( $id ))
//         die ( "id not a number." );

//     global $dblink;
    
//     $commandText = 
//         "delete from products "
//       . "  where productId = {$id}";
//     mysqli_query($dblink, $commandText); 
    
//     echo "Deleted: " . $id;
// }
?>
