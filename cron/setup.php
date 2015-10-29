<?
require_once 'config.php';
//check ip lấy tin
if(!check_ip_cron()){
    echo 'HTTP/1.0 404 Not Found';
    header("HTTP/1.0 404 Not Found");
    die();
}
$action = getValue('action','str','POST','');
$error_msg = '';
if($action == 'execute'){
    $myform = new generate_form();
    $myform->add('law_cat_id','law_cat_id',1,0,0,1);
    $myform->add('law_link_cat','law_link_cat',0,0,'',1);
    $myform->add('law_image','law_image',0,0,'',0);
    $myform->add('law_detail_link','law_detail_link',0,0,'',1);
    $myform->add('law_detail_title','law_detail_title',0,0,'',1);
    $myform->add('law_detail_teaser','law_detail_teaser',0,0,'',0);
    $myform->add('law_detail_content','law_detail_content',0,0,'',1);
    $myform->add('law_detail_source','law_detail_source',0,0,'',0);
    $myform->add('law_detail_tag','law_detail_tag',0,0,'',0);
    $myform->add('law_detail_remove','law_detail_remove',0,0,'',0);
    $myform->add('law_status_temp','law_status_temp',1,0,0,0);
    $myform->addTable('law');
    $error_msg = $myform->checkdata();
    if(!$error_msg){
        $db_execute = new db_execute($myform->generate_insert_SQL());
    }
}
?>
<html>
    <head>
        <title>Nhập luật lấy tin</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="form-law col-xs-5">
            <form action="" method="post">
                <input type="hidden" name="action" value="execute"/>
                <div class="form-group">
                    <label for="law_cat_id">Category</label>
                    <select name="law_cat_id" id="law_cat_id" class="form-control">
                        <?
                        //lấy ra danh mục
                        $db_cat = new db_query('SELECT * FROM categories WHERE cat_type = '.CATEGORY_TYPE_NEWS);
                        while($row_cat = mysqli_fetch_assoc($db_cat->result)){
                            echo '<option value="'.$row_cat['cat_id'].'">'.$row_cat['cat_name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="law_link_cat">Link category</label>
                    <input type="text" name="law_link_cat" id="law_link_cat" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_link">Rule link detail</label>
                    <input type="text" name="law_detail_link" id="law_detail_link" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_title">Rule title</label>
                    <input type="text" name="law_detail_title" id="law_detail_title" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_teaser">Rule teaser</label>
                    <input type="text" name="law_detail_teaser" id="law_detail_teaser" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_image">Rule image</label>
                    <input type="text" name="law_detail_image" id="law_detail_image" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_content">Rule content</label>
                    <input type="text" name="law_detail_content" id="law_detail_content" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_tag">Rule tag</label>
                    <input type="text" name="law_detail_tag" id="law_detail_tag" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_content">Rule source</label>
                    <input type="text" name="law_detail_source" id="law_detail_source" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="law_detail_content">Rule element remove</label>
                    <input type="text" name="law_detail_remove" id="law_detail_remove" class="form-control"/>
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
    </body>
</html>