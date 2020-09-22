<?php
// src/Msboard.php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="msgBoardORM",options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class Message
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $msgId;
    /** 
     * @ORM\Column(type="string", length=20) 
     */
    protected $userName;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $msg;
    /** 
     * @ORM\Column(type="datetime") 
     */
    protected $createTime;
    /** 
     * @ORM\Column(type="datetime") 
     */
    protected $updateTime;

    public function getId()
    {
        return $this->msgId;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($name)
    {
        $this->userName = $name;
    }
    
    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function getCreateTime()
    {
        return $this->createTime;
    }

    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }
}