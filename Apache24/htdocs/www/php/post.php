<?php
require_once './db.php';

function md_htmltopdf($name,$len=297)//A4 210mm×297mm
{
    $trans='';
    $pdfname=$len;
    if (297==$len) {
        $trans='&trans=1';
    }
    else
    {
        $pdfname='';
    }
    $isShrinking='--disable-smart-shrinking ';
    // $isShrinking='';

    $str=$isShrinking.'--enable-toc-back-links --javascript-delay 2000 --no-stop-slow-scripts --margin-bottom 0 --margin-top 0 --cache-dir "./cache" --page-height '.$len.' --page-width 210 "127.0.0.1/examples/preview.php?mdname='.$name.$trans.'" '.$name.$pdfname.'.pdf';
    error_log($str);
    exec('wkhtmltopdf.cmd '.$str,$out);
    error_log(print_r($out,true));
}
    if (isset($_POST['tpye'])) {
        switch ($_POST['tpye'])
        {
            case 'md_update_status':
            //这边用三元运算符对时间值是否存在进行判断，第一次创建文档时间从本地存储中是获取不到的
            $time=isset($_POST['time'])?$_POST['time']:0;
            $status=md_update_status('time',$_POST['name'],$time);
            if (false==$status) {
                echo "up";
                error_log(__FILE__.':'.__LINE__.':'.'up');
            }else if ($status['time']==$time) {
                error_log(__FILE__.':'.__LINE__.':'.'none');
                error_log(__FILE__.':'.__LINE__.':'.$status['time'].$time);
            }
            else{
                echo 'down';
                error_log(__FILE__.':'.__LINE__.':'.'down');
            }
            // error_log(__FILE__.':'.__LINE__.':'.isset($status['time'])?$status['time']:0.isset($_POST['time'])?$_POST['time']:0);
            error_log(__FILE__.':'.__LINE__.':'.'md_update_status');
          break;
        case 'md_update_up':
            md_update_up($_POST['name'],'now_null',$_POST['text'],'jason');
            error_log(__FILE__.':'.__LINE__.':'.'md_update_up');
          break;
        case 'md_update_down':
            $text=md_update_status('text',$_POST['name']);
            echo $text['text'];
            error_log(__FILE__.':'.__LINE__.':'.'md_update_down');
            break;
        case 'md_htmltopdf':
            if (isset($_POST['name'])) {
                if (isset($_POST['len'])) {
                    $url=md_htmltopdf($_POST['name'],$_POST['len']);
                }
                else{
                    md_htmltopdf($_POST['name']);
                }
            }
            error_log(__FILE__.':'.__LINE__.':'.'md_htmltopdf');
            if (isset($_POST['debug'])) {
                error_log(__FILE__.':'.__LINE__.':'.$_POST['debug']);
            }
            break;
        default:
            echo 'default';
        }
    }
    exit;
?>