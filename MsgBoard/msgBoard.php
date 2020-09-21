<?php
    require_once("dbConn.php");

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
        //總留言數
        $sqlGetMsgCount = "select count(*) as count from msgBoard";
        $reuslt         = $db->query($sqlGetMsgCount);
        $dataToClient[] = $reuslt->fetch(PDO::FETCH_ASSOC);
        
        //撈資料
        $startIdx    = $_POST["startIdx"];
        $numOfResult = $_POST["numOfResult"];
        $sqlGetMsg   = "select * from msgBoard order by createTime DESC LIMIT :startIdx , :numOfResult";

        $sqlGetMsg   = $db->prepare($sqlGetMsg);
        $sqlGetMsg->bindParam("startIdx", intval($startIdx), PDO::PARAM_INT);
        $sqlGetMsg->bindParam("numOfResult", intval($numOfResult), PDO::PARAM_INT);
        
        if (!$sqlGetMsg->execute()) {
            return $db->errorInfo();
        }

        while ($row = $sqlGetMsg->fetch(PDO::FETCH_ASSOC)) {
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
        
        $sqlDelMsg  = "delete from msgBoard where msgId = :msgIdToDel";
        $sqlDelMsg  = $db->prepare($sqlDelMsg);
        $sqlDelMsg->bindParam("msgIdToDel", intval($msgIdToDel), PDO::PARAM_INT);

        if ($sqlDelMsg->execute()){
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
