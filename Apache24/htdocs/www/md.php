<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/all.css"/>
    </head>
    <body>
        <nav class="site-navigation">
        <div class="build-date"><a href="javascript:;">BOOK</a></div>
        <br>
        <input type="text" id="newBook" onkeypress="if(event.keyCode==13) {btn.click();return false;}"/>
        <input type="submit" id="btn" value="New" onclick="window.location='./md_edit.php?mdname='+newBook.value;return false;" />
        <ul>
        <li>目录</li>
        <ol name="contents"></ol>
        </ul>

        
        </nav>
        <div class="site-content">
            <div id="test-editormd-view">
                <textarea id="append-test" style="display:none;"></textarea>
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
        function showBook(BookName)
        {
            console.log('BookName');
        }

        function addSiteNavigation(data){
            jsonBookList=eval(data);
            for (var i = jsonBookList.length - 1; i >= 0; i--) {
                // console.log(jsonBookList[i]['name']);
                Bookitem=$('<a></a>').text(jsonBookList[i]['name']);
                
                // a=jsonBookList[i]['name'];
                Bookitem.attr("href",'javascript:;');
                Bookitem.click(function(){
                // console.log(this.text+'1');
                $('div.mdpreview').hide();
                if($('div#'+this.text).length>0)
                {
                    console.log('iframe 存在')
                    $('div#'+this.text).show();
                }else{
                    console.log('iframe 不存在')                  
                    BookBody='<textarea name="'+this.text+'" class="mdpreview" style="display:none;"></textarea>';
                    BookBody=$('<div></div>').append(BookBody);
                    BookBody.attr('id',this.text);
                    BookBody.attr('class','mdpreview');

                    $('div.site-content').append(BookBody);
                    md_getBookText(this.text);
                }
                })
                Bookitem=$('<div></div>').append(Bookitem)
                Bookedit='<div><a href="/md_edit.php?mdname='+jsonBookList[i]["name"]+'"><img src="/img/edit.png"><a href="/md_edit.php?mdname='+jsonBookList[i]["name"]+'"><img src="/img/del.png"></div>';
                Bookitem=$('<li></li>').append(Bookitem,Bookedit);
                $('ol[name=contents]').append(Bookitem);
            }
        }
        function md_getNameList() {
            $.get("./php/get.php",{
                type:"mdNameList",
            },
                function(data,status){
                console.log("Data: " + data + "\nStatus: " + status);
                addSiteNavigation(data);
            })
        }
        function md_getBookText(mdTextareaID) {
            $.get("./php/get.php",{
                type:"mdBookText",
                mdname:mdTextareaID,
            },
                function(data,status){
                console.log("\nStatus: " + status);
                $('.mdpreview[name='+mdTextareaID+']').text(data);
                $(function() {
                    var testEditormdView;
                    testEditormdView = editormd.markdownToHTML(mdTextareaID, {
                        htmlDecode      : "style,script,iframe",  // you can filter tags decode
                        emoji           : true,
                        taskList        : true,
                        // tex             : true,  // 默认不解析
                        flowChart       : true,  // 默认不解析
                        sequenceDiagram : true,  // 默认不解析
                    });
                });
            })
        }
        $(document).ready(function(){
            md_getNameList();

        });
        </script>
    </body>
</html>
