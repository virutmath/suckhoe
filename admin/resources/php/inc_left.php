<?php
$isAdmin = isset($_SESSION["isAdmin"]) ? intval($_SESSION["isAdmin"]) : 0;
$user_id = isset($_SESSION["user_id"]) ? intval($_SESSION["user_id"]) : 0;
$sql = '';
if($isAdmin != 1){
	$sql = ' INNER JOIN admin_users_right ON(adu_admin_module_id  = mod_id AND adu_admin_id = ' . $user_id . ')';
}
$db_menu = new db_query("SELECT * 
						 FROM modules
						 " . $sql . "
						 ORDER BY mod_order ASC, mod_id ASC");

?>
<ul>
<?php
$menu = $db_menu->resultArray();
foreach($menu as $mod){
    if(!file_exists("modules/" . $mod["mod_path"] . "/inc_security.php") && !file_exists("core/" . $mod["mod_path"] . "/inc_security.php")) continue;
    $filepath = file_exists("modules/" . $mod["mod_path"] . "/inc_security.php") ? 'modules' : 'core';
    ?>
    <li class="module_link">
        <label class="module_name collapsed" data-toggle="collapse" data-target="#module_<?=$mod['mod_id']?>" >
            <span class="menu-label"><?=$mod['mod_name']?></span><i class="fa fa-angle-right"></i>
        </label>
        <?php 
        $arraySub = explode("|",$mod["mod_listname"]);
		$arrayUrl = explode("|",$mod["mod_listfile"]);
        ?>
        <div id="module_<?=$mod['mod_id']?>" class="module_list collapse">
            <?php foreach($arraySub as $key=>$value):?>
            <label class="menu-label"><a  href="<?=$filepath.'/'.$mod['mod_path'].'/'.$arrayUrl[$key]?>" onclick="return false" target="_blank"><img src="resources/img/arrow.gif"/>&nbsp;<?=$arraySub[$key]?></a></label>
            <?php endforeach;?>
        </div>
    </li>
    <?php
}
?>
</ul>