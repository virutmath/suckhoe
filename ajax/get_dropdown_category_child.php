<?
$record_id = getValue('record_id', 'int', 'POST', 0);
$table = getValue('table','str','POST','');
$name_field = getValue('name_field','str','POST','');
$id_field = getValue('id_field','str','POST','');
$parent_field = getValue('parent_field','str','POST','');

$db_cat_child = new db_query('SELECT '.$id_field.','.$name_field.' FROM '.$table.' WHERE '.$parent_field.' = ' . $record_id);
while ($row = mysqli_fetch_assoc($db_cat_child->result)) {
    ?>
    <option value="<?= $row[$id_field] ?>"><?= $row[$name_field] ?></option>
<?
}