<?
require_once 'config.php';
$action = getValue('action','str','POST','');
$error_msg = '';
if($action == 'execute'){
    $myform = new generate_form();
    $myform->addTable('categories');
    $myform->add('cat_name','cat_name',0,0,'',1,'Bạn chưa nhập tên danh mục');
    $myform->add('cat_title','cat_title',0,0,'');
    $error_msg = $myform->checkdata();
    if(!$error_msg){
        $db_insert = new db_execute($myform->generate_insert_SQL());
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
<?if($action) echo $error_msg ? $error_msg : 'Thêm thành công'?>
    <div class="container">
        <div class="form-law col-xs-5">
            <form action="" method="post">
                <input type="hidden" name="action" value="execute"/>
                <div class="form-group">
                    <label for="cat_name">Category name</label>
                    <input type="text" name="cat_name" id="cat_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cat_name">Category title seo</label>
                    <input type="text" name="cat_title" id="cat_title" class="form-control">
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div>
        Danh sách category
        <table>
            <tr>
                <th>Tên danh mục</th>
                <th>Tiêu đề SEO</th>
            </tr>
            <?
            $db_cat = new db_query('SELECT * FROM categories');
            while($row = mysqli_fetch_assoc($db_cat->result)){
                ?>
            <tr>
                <td><?=$row['cat_name']?></td>
                <td><?=$row['cat_title']?></td>
            </tr>
            <?
            }
            ?>
        </table>
    </div>
</body>
</html>