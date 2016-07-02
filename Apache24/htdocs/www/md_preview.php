<?php
require_once './php/db.php';

if (isset($_GET['mdname'])) {
    $mdname=$_GET['mdname'];
}
else{
    $mdname="";
}
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8" />
        <title>HTML Preview</title>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="src/editor.md/css/editormd.preview.css" />
        <style>            
            .editormd-html-preview {
                /*width: 90%;*/
                margin: 0 auto;
                width:718px;//强制指定为A4的宽度 以便在webkit中得到相对的高度
            }
        </style>
    </head>
    <body>
        <div id="layout">
            <header>
                <h1><?php echo $mdname;?></h1>
            </header>
            <div id="test-editormd-view">
                <textarea id="append-test" style="display:none;">
                <?php //获取正文内容
                    $text=md_update_status('text',$mdname);
                    echo $text['text'];
                    ?>
                </textarea>          
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="src/editor.md/lib/marked.min.js"></script>
        <script src="src/editor.md/lib/prettify.min.js"></script>
        
        <script src="src/editor.md/lib/raphael.min.js"></script>
        <script src="src/editor.md/lib/underscore.min.js"></script>
        <script src="src/editor.md/lib/sequence-diagram.min.js"></script>
        <script src="src/editor.md/lib/flowchart.min.js"></script>
        <script src="src/editor.md/lib/jquery.flowchart.min.js"></script>

        <script src="src/editor.md/editormd.js"></script>
        <script type="text/javascript">
        // 1英寸(in)=25.4毫米(mm)
        //webkit 默认 96dpi
        //mm px/(96/25.4)
        //A4是210毫米×297毫米 （上下边距 10mm）
        //宽度为718
        var pixelsToMm=96/25.4;
            $(function() {
                var testEditormdView;
                
                testEditormdView = editormd.markdownToHTML("test-editormd-view", {
                    htmlDecode      : "style,script,iframe",  // you can filter tags decode
                    emoji           : true,
                    taskList        : true,
                    // tex             : true,  // 默认不解析
                    flowChart       : true,  // 默认不解析
                    sequenceDiagram : true,  // 默认不解析
                });
            });

            function js_getDPI() {
                var arrDPI = new Array();
                if (window.screen.deviceXDPI != undefined) {
                    arrDPI[0] = window.screen.deviceXDPI;
                    arrDPI[1] = window.screen.deviceYDPI;
                }
                else {
                    var tmpNode = document.createElement("DIV");
                    tmpNode.style.cssText = "width:1in;height:1in;position:absolute;left:0px;top:0px;z-index:99;visibility:hidden";
                    document.body.appendChild(tmpNode);
                    arrDPI[0] = parseInt(tmpNode.offsetWidth);
                    arrDPI[1] = parseInt(tmpNode.offsetHeight);
                    tmpNode.parentNode.removeChild(tmpNode);   
                }
                return arrDPI;
            }
            window.onload = function () {
                window.resizeTo(100,100);
                console.log(document.body.scrollHeight/pixelsToMm);
                var dpi=js_getDPI();
                var w=window.innerWidth
                || document.documentElement.clientWidth
                || document.body.clientWidth;

                var h=window.innerHeight
                || document.documentElement.clientHeight
                || document.body.clientHeight;
                debug
                =' scrollHeight:'+document.body.scrollHeight
                +' scrollWidth:' +document.body.scrollWidth
                +' len:'+document.body.scrollHeight/pixelsToMm
                +'dpi width: ' +dpi[0]
                +'dpi height: ' +dpi[1]
                +"浏览器的内部窗口宽度：" + w + "，高度：" + h + "。"
                +"H:"+window.screen.heigh
                +"W"+window.screen.width
                ;
                    $.post("./php/post.php",
                    {
                        tpye:"md_htmltopdf",
                        <?php                         
                        if (isset($_GET['trans'])) {
                            echo 'name:"'.$mdname.'",';
                        }
                        ?>
                        len:document.body.scrollHeight/pixelsToMm+40,//上下边框各10
                        debug:debug
                    });
                <?php 
                if (isset($_GET['trans'])) {
                    echo 'document.write("<h1>sorry!</h1>");';
                }
                ?>
            }
        </script>
    </body>
</html>