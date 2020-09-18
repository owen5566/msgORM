<?php
    require_once("dbConn.php");
    date_default_timezone_set("Asia/Taipei");
    
    $method = $_SERVER['REQUEST_METHOD']; 
    $url = explode("/", rtrim($_GET["action"], "/"));

    switch ($method." ".$url[0]) {
        case 'POST insert':
            var_dump(newMsg());
        break;
        case 'POST getMsg':
            echo json_encode(getMsg());
        break;
    }

    function getMsg()
    {
        global $db;
        $dataToClient = array();
        $sqlGetMsg    = "select * from msgBoard";
        $reuslt       = $db->query($sqlGetMsg);

        while ($row = $reuslt->fetch(PDO::FETCH_ASSOC)) {
            $dataToClient[] = $row;
        }
        return $dataToClient;
    }

    function newMsg()
    {
        global $db;
        $userName    = $_POST["userName"];
        $msg         = $_POST["msg"];
        $createTime  = Date("Y-m-d H:i:s");

        $sqlInsertMsg = $db->prepare("insert into msgBoard values(null, :userName, :msg, :createTime, :createTime)");
        $sqlInsertMsg->bindParam("userName", $userName, PDO::PARAM_STR);
        $sqlInsertMsg->bindParam("msg", $msg, PDO::PARAM_STR);
        $sqlInsertMsg->bindParam("createTime", $createTime, PDO::PARAM_STR);

        if (!$sqlInsertMsg->execute()) {
            return $db->errorInfo();
        } else {
            return 1;
        }

    }

    function delMsg()
    {
        global $db;

    }
