<?
require '../cron/config.php';

$link = 'http://www.thuocbietduoc.com.vn/thuoc-5030/amizepin.aspx';
echo '<a href="'.$link.'" target="_blank">'.$link.'</a><br>';


$html_content = curl_get_content($link);
$html_content = str_get_html($html_content);
foreach($html_content->find('td') as $td) {
    $check_content = $td->plaintext;
    $check_content = trim($check_content);
    switch ($check_content) {
        case 'Nhà sản xuất:':
            $pha_nsx = $td->next_sibling()->plaintext;
            $pha_nsx = trim($pha_nsx);
            continue;
            break;
    }
}

echo $pha_nsx;die();