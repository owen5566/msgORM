<?php
    require_once("dbConn.php");
    date_default_timezone_set("Asia/Taipei");    

    $url = explode("/", rtrim($_GET["action"], "/"));

    switch ($url[0]) {
        case 'insert':
            echo newMsg();
        break;
        case 'getMsg':
            echo json_encode(getMsg());
        break;
        case 'delMsg':
            echo delMsg();
        break;
        case 'updateMsg':
            echo updateMsg();
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
        $msgIdToDel = $_POST["msgIdToDel"];
        $sqlDelMsg  = "delete from msgBoard where msgId = $msgIdToDel";

        if ($db->query($sqlDelMsg)){
            return 1;
        } else {
            return 0;
        }
    }

    function updateMsg()
    {
        global $db;
        $msgIdToUpdate = $_POST["msgId"];
        $msgToUpdate   = $_POST["msg"];
        $updateTime    = Date("Y-m-d H:i:s");

        $sqlUpdateMsg = $db->prepare("update `msgBoard` 
                                      set `msg` = :msgToUpdate ,
                                      updateTime = :updateTime 
                                      where `msgId` = :msgIdToUpdate");
        $sqlUpdateMsg->bindParam("msgToUpdate", $msgToUpdate, PDO::PARAM_STR);
        $sqlUpdateMsg->bindParam("updateTime", $updateTime, PDO::PARAM_STR);
        $sqlUpdateMsg->bindParam("msgIdToUpdate", intval($msgIdToUpdate), PDO::PARAM_INT);
        
        if (!$sqlUpdateMsg->execute()) {
            return $db->errorInfo();
        } else {
            return 1;
        }
    }
