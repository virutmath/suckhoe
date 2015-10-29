<?
require 'config.php';
$lastmod_first = date('Y-m-d') . 'T00:00:00+07:00';
ob_clean();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<url>
    <loc>'.DOMAIN_URL . $link_detail.'</loc>
    <lastmod>'.$lastmod_first.'</lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
</url>';

$db = new db_query('SELECT sec_id,sec_name FROM sections');
while($row = mysqli_fetch_assoc($db->result)){
    $link_detail = generate_section_detail($row);
    ?>
    <url>
        <loc><?=DOMAIN_URL . $link_detail?></loc>
        <?/*
        <xhtml:link rel="alternate" media="only screen and max-width: 480px" href="http://m.24h.com.vn/" />
        */?>
        <lastmod><?=$lastmod_first?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
<?
}unset($db)?>
</urlset>