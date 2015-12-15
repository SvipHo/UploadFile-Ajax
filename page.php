<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 2015/12/9
 * Time: 14:36
 */
    header('Content-Type:text/html;charset=utf-8');
    $dns = 'mysql:host=localhost;dbname=publiccations;charset=utf8';
    $user = 'root';
    $pwd = '1234qwer';
    $type = array('Feciton','play','Non-Fecition');
    try{
        $pdo = new PDO($dns,$user,$pwd);
    }catch (Exception $e){
        die('Could not connect to the database'.$e);
    }
    $pdo->exec("SET NAMES 'UTF8'");

    $sql = "select count(id) from classics";
    $page = $_GET['p']?$_GET['p']:1;
    $prePage = $page-1;
    $nextPage = $page+1;
    $Page_size = 20;
    $result = $pdo->query($sql);
    $countPages = $result->fetch()['count(id)'];
    $page_count  = ceil($countPages/$Page_size);
    $offset = $Page_size*($page-1);


    //====================
    $init=1;
    $page_len = 9;
    $max_p = $page_count; //最大页数
    $pages = $page_count;//最大页数
    $page_len = ($page_len%2)?$page_len:$page_len+1;//页码个数
    $pageoffset = ($page_len-1)/2;//页码个数左右偏移量

    $key='<div class="page">';
    $key.="<span>$page/$pages</span> "; //第几页,共几页
    if($page!=1){
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?p=1\">第一页</a> "; //第一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?p=".($page-1)."\">上一页</a>"; //上一页
    }else {
        $key.="第一页 ";//第一页
        $key.="上一页"; //上一页
    }
    if($pages > $page_len){
    //如果当前页小于等于左偏移
        if($page <= $pageoffset){
            $init = 1;
            $max_p = $page_len;
        }else{
    //如果当前页大于左偏移
    //如果当前页码右偏移超出最大分页数
            if($page+$pageoffset>=$pages+1){
                $init = $pages-$page_len+1;
            }else{
    //左右偏移都存在时的计算
                $init = $page-$pageoffset;
                $max_p = $page+$pageoffset;
            }
        }
    }
    for($i=$init;$i<=$max_p;$i++){
        if($i==$page){
            $key.=' <span>'.$i.'</span>';
        } else {
            $key.=" <a href=\"".$_SERVER['PHP_SELF']."?p=".$i."\">".$i."</a>";
        }
    }
    if($page!=$pages){
        $key.=" <a href=\"".$_SERVER['PHP_SELF']."?p=".($page+1)."\">下一页</a> ";//下一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?p={$pages}\">最后一页</a>"; //最后一页
    }else {
        $key.="下一页 ";//下一页
        $key.="最后一页"; //最后一页
    }
    $key.='</div>';

     echo $key;


    $sql = "select * from classics limit $offset,$Page_size";
    //echo $sql;
    $result = $pdo->query($sql);
    $res = $result->fetchAll();
    //$pdo = null;
    //echo '<pre>';
    //print_r($result->fetchAll());
    //echo '</pre>';
    ?>
    <html>
    <head>
        <style>
            .zebraHover{
                color: brown;
            }
        </style>
        <script src="jquery.js"></script>
        <script>
            $(function(){
                $("#tab tr").hide().fadeIn('slow');
                $("#tab tr").hover(function(){
                    $(this).addClass('zebraHover');
                },function(){
                    $(this).removeClass('zebraHover');
                });
            });
        </script>
    </head>
    <body>
    <form>
        <input type="text" name="p" style="width: 20px;">
    <!--    <input type="submit" value="sub" />-->
    </form>
    <table id="tab">
        <tr><th>author</th><th>title</th><th>type</th><th>year</th><th>time</th></tr>
        <?php foreach($res as $v){
               echo '<tr><th>'.$v['author'].'</th><th>'.$v['title'].'</th><th>'.$v['type'].'</th>
                <th>'.$v['year'].'</th><th>'.$v['time'].'</th></tr>';
            }?>

       </table>
    <div id="img">
        <form>
            search<input type="text" name="search" />
            <input type="submit" value="sub" />
        </form>

        <form>
            sushe_no<input type="text" name="sushe_no" />
            comment<input type="text" name="comment" />
            <input type="submit" value="sub" />
        </form>
    </div>
    </body>
    </html>
    <?php
    //$sql1 = "select * from sushe where MATCH (sushe_no,comment) against('".$_GET['search']."')";
    //echo $sql1;
    //$result = $pdo->query($sql1);
    //echo '<pre>';
    //print_r($result->fetchAll());
    //echo '</pre>';
//    $sql1 = "insert into sushe(sushe_no,comment) VALUES ('".$_GET['sushe_no']."','".$_GET['comment']."')";
//    $result = $pdo->query($sql1);
//    echo '<pre>';
//    if($result){
//        echo 'success';
//    }
//    echo '</pre>';
    ?>