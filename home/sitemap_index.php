<?
require 'config.php';
//Chia ra các sitemap con
$lastmod_first = date('Y-m-d') . 'T00:00:00+07:00';

function generate_sitemap_element ($url, $lastmod){
    return '<sitemap>
                <loc>'.$url.'</loc>
                <lastmod>'.$lastmod.'</lastmod>
            </sitemap>';
}

//sitemap category
$sitemap_cat = DOMAIN_URL . '/sitemap-category.xml';
//sitemap news
$db_count = new db_count('SELECT count(*) as count FROM news WHERE new_active = 1');
$all_size = $db_count->total;unset($db_count);
$number_page = (int)($all_size / 10000);
//sitemap hoidap
$db_count = new db_count('SELECT count(*) as count FROM questions WHERE que_type = 0 AND que_status = 1');
$all_size_hoidap = $db_count->total;unset($db_count);
$number_page_hoidap = (int)($all_size_hoidap / 10000);

ob_clean();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';?>
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
              xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?=generate_sitemap_element($sitemap_cat,$lastmod_first)?>
<? for($i = 0;$i <= $number_page; $i ++){
    ?>
    <sitemap>
        <loc><?=DOMAIN_URL?>/sitemap-news-<?=$i?>.xml</loc>
        <lastmod><?=$lastmod_first?></lastmod>
    </sitemap>
    <?
}?>
<? for($i = 0;$i <= $number_page_hoidap; $i ++){
    ?>
    <sitemap>
        <loc><?=DOMAIN_URL?>/sitemap-hoidap-<?=$i?>.xml</loc>
        <lastmod><?=$lastmod_first?></lastmod>
    </sitemap>
<?
}?>
<?
//sitemap news mới trong ngày
$time_news = date('Y-m-d');
?>
<sitemap>
    <loc><?=DOMAIN_URL?>/sitemap-time-<?=$time_news?>.xml</loc>
    <lastmod><?=$lastmod_first?></lastmod>
</sitemap>
<?
//sitemap section
?>
<sitemap>
    <loc><?=DOMAIN_URL?>/sitemap-section.xml</loc>
    <lastmod><?=$lastmod_first?></lastmod>
</sitemap>
    <sitemap>
        <loc><?=DOMAIN_URL?>/sitemap-category-hoidap.xml</loc>
        <lastmod><?=$lastmod_first?></lastmod>
    </sitemap>
    <?/*
<sitemap>
    <loc><?=DOMAIN_URL?>/sitemap-image.xml</loc>
    <lastmod><?=$lastmod_first?></lastmod>
</sitemap>
    */?>
</sitemapindex>