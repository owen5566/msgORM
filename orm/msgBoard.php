<?php
    require_once("bootstrap.php");

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
        global $entityManager;
        $dataToClient = ["count"=>0];

        //總留言數
        $msgsRepository = $entityManager->getRepository('Message');
        $msgs = $msgsRepository->findAll();
        foreach ($msgs as $msg) {
            $dataToClient["count"] += 1;
        }
        //撈資料
        $startIdx    = ($dataToClient["count"]<=$_POST["startIdx"]) ? intval($_POST["startIdx"])-10 : intval($_POST["startIdx"]);
        $numOfResult = $_POST["numOfResult"];
        $dqlGetMsg   = "SELECT m FROM Message m ORDER BY m.createTime DESC";

        $dqlGetMsg   = $entityManager->createQuery($dqlGetMsg);
        $dqlGetMsg->setFirstResult($startIdx);
        $dqlGetMsg->setMaxResults($numOfResult);
        
        if (!$data = $dqlGetMsg->getArrayResult()) {
            return "error";
        }
        foreach ($data as $d) {
            $dataToClient[] = $d;
        }
        return $dataToClient;
    }

    function newMsg()
    {
        global $entityManager;
        $userName    = $_POST["userName"];
        $msg         = $_POST["msg"];
        $createTime  = new DateTime("now");

        $newMsg = new Message();
        $newMsg->setUserName($userName);
        $newMsg->setMsg($msg);
        $newMsg->setCreateTime($createTime);
        $newMsg->setUpdateTime($createTime);

        $entityManager->persist($newMsg);
        $entityManager->flush();

        if (!$newMsg->getId()) {
            return "insert error";
        } else {
            return 1;
        }

    }

    function delMsg()
    {
        global $entityManager;
        $msgIdToDel = $_POST["msgIdToDel"];
        
        $dqlDelMsg  = "DELETE Message m where m.msgId = :msgIdToDel";
        $dqlDelMsg  = $entityManager->createQuery($dqlDelMsg);
        $dqlDelMsg->setParameter("msgIdToDel", intval($msgIdToDel));

        return $dqlDelMsg->getResult();    
    }

    function updateMsg()
    {
        global $entityManager;
        $msgIdToUpdate = $_POST["msgId"];
        $msgToUpdate   = $_POST["msg"];
        $updateTime    = new DateTime("now");

        $msg = $entityManager->find('Message',$msgIdToUpdate);
        $msg->setMsg($msgToUpdate);
        $msg->setUpdateTime($updateTime);

        $entityManager->flush();

        if (0) {
            return "update error";
        } else {
            return 1;
        }
    }
