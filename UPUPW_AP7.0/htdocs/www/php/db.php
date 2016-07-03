<?php
//使用sqlite
$PHPROOT='D:/';
$dbserver='sqlite:'.$PHPROOT.'/editormd.db';
$dbuser='editormd';
$dbmima='admin';
//使用mysql
// $dbserver='mysql:host=localhost;dbname=zjwdb_547072';
// $dbuser='zjwdb_547072';
// $dbmima='NnN123456';

//判断数据表是否存在 不存在则创建
$db = new PDO($dbserver, $dbuser, $dbmima);
$sth = $db->exec("
CREATE TABLE if not EXISTS document (
  name text KEY NOT NULL,
  time INT  NOT NULL,
  text text NOT NULL,
  auther text NOT NULL
);");

//如果没有数据返回false
//时间数据格式2016-05-20 00:00:00
function md_update_status($type,$name,$time=0)
{
    global $dbserver,$dbuser,$dbmima;
    //php7中不再使用mysql接口 使用PDO
    $db = new PDO($dbserver, $dbuser, $dbmima);
    $sql = "SELECT "
    .$type
    ." FROM `document` WHERE NAME = '"
    .$name
    ."' AND TIME >= '"
    .$time
    ."'";
    error_log(__FILE__.':'.__LINE__.':'.$sql);
    $query = $db->query($sql);
    //PDO::FETCH_ASSOC 返回键值对 默认返回键值对+索引
    $date=$query->fetch(PDO::FETCH_ASSOC);
    // error_log(__FILE__.':'.__LINE__.': QUERY '.print_r($date,true));
    return $date;
}

function md_update_up($name,$time,$text,$auther)
{
    global $dbserver,$dbuser,$dbmima;
    $db = new PDO($dbserver, $dbuser, $dbmima);

    //判断数据有没有数据 没有插入 有就更新
    $isInsert=$db->query("select name from `document` where name='".$name."'");
    // error_log(__FILE__.':'.__LINE__.':'.$isInsert);

    if ($isInsert->fetch(PDO::FETCH_ASSOC)) {
        //更新数据 使用 prepare不需要要考虑引号 更方便 更安全
        //获取时间将时间转成时间戳（s） 不然new() 得到的时201505。。。这样的数据
        //注意这边得到的时间戳是 (s) 而js 中得到的时间戳是 (ms)
        $sth = $db->prepare("UPDATE `document` SET time=:time, text=:text, auther=:auther where name =:name");

        //SQL语句是在这边执行的
        $result = $sth->execute(array (
                ':name' => $name,
                ':time' => time(),
                ':text' => $text,
                ':auther' => $auther
        ));
        error_log(__FILE__.':'.__LINE__.': UPDATE '.$result);
    }
    else
    {
        //插入数据
        $sth = $db->prepare("INSERT INTO `document` (`name`, `time`, `text`, `auther`) VALUES (:name, :time, :text, :auther)"
        );
        //用$limit1得到一个结果
        $result = $sth->execute(array (
                ':name' => $name,
                ':time' => time(),
                ':text' => $text,
                ':auther' => $auther
        ));
        error_log(__FILE__.':'.__LINE__.': INSERT time:'.time().$result);
    }
    return $result;
}
//md_update_up('132','s','123','3');







//如果没有数据返回false
//时间数据格式2016-05-20 00:00:00
function DB_mdQueryNameList()
{
    global $dbserver,$dbuser,$dbmima;
    //php7中不再使用mysql接口 使用PDO
    $db = new PDO($dbserver, $dbuser, $dbmima);
    $sql = "select name,time,auther from 'document' limit 0,1000";
    error_log(__FILE__.':'.__LINE__.':'.$sql);
    $query = $db->query($sql);
    //PDO::FETCH_ASSOC 返回键值对 默认返回键值对+索引
    $date=$query->fetchAll(PDO::FETCH_ASSOC);
    error_log(__FILE__.':'.__LINE__.': QUERY '.print_r($date,true));
    return $date;
}

?>