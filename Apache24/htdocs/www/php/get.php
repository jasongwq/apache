<?php
require_once './db.php';

function get_allfiles($path,&$files) {  
    if(is_dir($path)){  
        $dp = dir($path);  
        while ($file = $dp ->read()){  
            if($file !="." && $file !=".."){  
                get_allfiles($path."/".$file, $files);  
            }  
        }  
        $dp ->close();  
    }  
    if(is_file($path)){  
        $files[] =  $path;  
    }  
}
function get_filenamesbydir($dir){  
    $files =  array();  
    get_allfiles($dir,$files);  
    return $files;
}
function mv_getlist()
{
    $json_list = array();
    //改变目录
    $dir=getcwd();
    chdir('../');
    $filenames = get_filenamesbydir("video");
    chdir($dir);

    $i=0;
    foreach ($filenames as $value) {
        $json_list[$i]['title']=$value;
        $json_list[$i]['m4v']=$value;
        $i++;
    }
    return $json_list;
}
function md_getNameList()
{
    return DB_mdQueryNameList();//从数据库中查询
}

    if (isset($_GET['type'])) {
        switch ($_GET['type'])
        {
        case 'mv_list':
            $json_list=mv_getlist();
            $json_list=json_encode($json_list);
            echo $json_list;
            error_log(__FILE__.':'.__LINE__.':'.$json_list);
            error_log(__FILE__.':'.__LINE__.':'.'mv_list');
            if (isset($_GET['debug'])) {
                error_log(__FILE__.':'.__LINE__.':'.$_GET['debug']);
            }
            break;
        case 'mdNameList':
            $json_list=md_getNameList();
            $json_list=json_encode($json_list);
            echo $json_list;
            error_log(__FILE__.':'.__LINE__.':'.$json_list);
            error_log(__FILE__.':'.__LINE__.':'.'mdNameList');
            if (isset($_GET['debug'])) {
                error_log(__FILE__.':'.__LINE__.':'.$_GET['debug']);
            }
            break;
        case 'mdBookText':
            $text=md_update_status('text',$_GET['mdname']);
            echo $text['text'];
            if (isset($_GET['debug'])) {
                error_log(__FILE__.':'.__LINE__.':'.$_GET['debug']);
            }
            break;

        default:
            echo 'default';
        }
    }
    exit;
?>