<?
require 'config.php';
$id = 19182;
$tag_string = 'đau đầu,hội chứng đau nửa đầu vai gáy,chứng đau nửa đầu vai gáy,hội chứng đau vai gáy,chứng đau vai gáy,tập luyện thể lực,đau vai gáy,dậy sớm tập thể dục,đau nửa đầu,đau vai gáy khám ở đâu';
$array_relate = get_question_relate($tag_string,5,$id,26);
var_dump($array_relate);