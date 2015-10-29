<?php
function form_open($a='',$b='',$c=array()){if($b==''){$b='method="post"';}$d='<form action="'.$a.'"';$d.=_attributes_to_string($b,TRUE);$d.='>';if(is_array($c)AND count($c)>0){$d.=sprintf("<div style=\"display:none\">%s</div>",form_hidden($c));}return $d;}function form_open_multipart($a='',$b=array(),$c=array()){if(is_string($b)){$b.=' enctype="multipart/form-data"';}else{$b['enctype']='multipart/form-data';}return form_open($a,$b,$c);}function form_hidden($e,$f='',$g=FALSE){static $d;if($g===FALSE){$d="\n";}if(is_array($e)){foreach($e as $h=>$j){form_hidden($h,$j,TRUE);}return $d;}if(!is_array($f)){$d.='<input type="hidden" name="'.$e.'" value="'.$f.'" />'."\n";}else{foreach($f as $l=>$m){$l=(is_int($l))?'':$l;form_hidden($e.'['.$l.']',$m,TRUE);}}return $d;}function form_input($n='',$f='',$o=''){$p=array('type'=>'text','name'=>((!is_array($n))?$n:''),'value'=>$f);if(is_array($n)&&$n['type']=='file'){return '<input '._parse_form_attributes($n,$p).$o.' />';}else{return "<input "._parse_form_attributes($n,$p).$o." />";}}function form_password($n='',$f='',$o=''){if(!is_array($n)){$n=array('name'=>$n);}$n['type']='password';return form_input($n,$f,$o);}function form_upload($n='',$f='',$o=''){if(!is_array($n)){$n=array('name'=>$n);}$n['type']='file';return form_input($n,$f,$o);}function form_textarea($n='',$f='',$o=''){$p=array('name'=>((!is_array($n))?$n:''));if(!is_array($n)OR!isset($n['value'])){$j=$f;}else{$j=$n['value'];unset($n['value']);}$e=(is_array($n))?$n['name']:$n;return "<textarea "._parse_form_attributes($n,$p).$o.">".$j."</textarea>";}function form_multiselect($e='',$q=array(),$r=array(),$o=''){if(!strpos($o,'multiple')){$o.=' multiple="multiple"';}return form_dropdown($e,$q,$r,$o);}function form_dropdown($e='',$q=array(),$r=array(),$o=''){if(!is_array($r)){$r=array($r);}if(count($r)===0){if(isset($_POST[$e])){$r=array($_POST[$e]);}}if($o!='')$o=' '.$o;$s=(count($r)>1&&strpos($o,'multiple')===FALSE)?' multiple="multiple"':'';$d='<select name="'.$e.'"'.$o.$s.">\n";foreach($q as $h=>$j){$h=(string)$h;if(is_array($j)&&!empty($j)){$d.='<optgroup label="'.$h.'">'."\n";foreach($j as $t=>$u){$w=(in_array($t,$r))?' selected="selected"':'';$d.='<option value="'.$t.'"'.$w.'>'.(string)$u."</option>\n";}$d.='</optgroup>'."\n";}else{$w=(in_array($h,$r))?' selected="selected"':'';$d.='<option value="'.$h.'"'.$w.'>'.(string)$j."</option>\n";}}$d.='</select>';return $d;}function form_checkbox($n='',$f='',$x=FALSE,$o=''){$p=array('type'=>'checkbox','name'=>((!is_array($n))?$n:''),'value'=>$f);if(is_array($n)AND array_key_exists('checked',$n)){$x=$n['checked'];if($x==FALSE){unset($n['checked']);}else{$n['checked']='checked';}}if($x==TRUE){$p['checked']='checked';}else{unset($p['checked']);}return "<input "._parse_form_attributes($n,$p).$o." />";}function form_radio($n='',$f='',$x=FALSE,$o=''){if(!is_array($n)){$n=array('name'=>$n);}$n['type']='radio';return form_checkbox($n,$f,$x,$o);}function form_submit($n='',$f='',$o=''){$p=array('type'=>'submit','name'=>((!is_array($n))?$n:''),'value'=>$f);return "<input "._parse_form_attributes($n,$p).$o." />";}function form_reset($n='',$f='',$o=''){$p=array('type'=>'reset','name'=>((!is_array($n))?$n:''),'value'=>$f);return "<input "._parse_form_attributes($n,$p).$o." />";}function form_button($n='',$y='',$o=''){$p=array('name'=>((!is_array($n))?$n:''),'type'=>'button');if(is_array($n)AND isset($n['content'])){$y=$n['content'];unset($n['content']);}return "<button "._parse_form_attributes($n,$p).$o.">".$y."</button>";}function form_label($z='',$aa='',$b=array()){$bb='<label';if($aa!=''){$bb.=" for=\"$aa\"";}if(is_array($b)AND count($b)>0){foreach($b as $h=>$j){$bb.=' '.$h.'="'.$j.'"';}}$bb.=">$z</label>";return $bb;}function form_close($o=''){return "</form>".$o;}function _extend_attributes($b,&$cc){if(is_array($b)){foreach($cc as $h=>$j){if(isset($b[$h])){$cc[$h]=$b[$h];unset($b[$h]);}}if(count($b)>0){$cc=array_merge($cc,$b);}}return $cc;}function _parse_form_attributes($b,$cc){$cc=_extend_attributes($b,$cc);$dd='';foreach($cc as $h=>$j){$dd.=$h.'="'.$j.'" ';}return $dd;}function _attributes_to_string($b,$ee=FALSE){if(is_string($b)AND strlen($b)>0){if($ee==TRUE AND strpos($b,'method=')===FALSE){$b.=' method="post"';}return' '.$b;}if(is_object($b)AND count($b)>0){$b=(array)$b;}if(is_array($b)AND count($b)>0){$ff='';if(!isset($b['method'])AND $ee===TRUE){$ff.=' method="post"';}foreach($b as $h=>$j){$ff.=' '.$h.'="'.$j.'"';}return $ff;}}function tinyMCE($e,$aa,$f,$gg='99%',$hh=450,$ii='advanced'){$jj='';$jj.='<textarea name="'.$e.'" id="'.$aa.'" style="width:'.$gg.';height:'.$hh.'px">'.$f.'</textarea>';$jj.='<script type="text/javascript">
            tinyMCE.init({
                mode:"exact",
                elements:"'.$aa.'",
                theme:"'.$ii.'",
                plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                relative_urls : false,
                // Example content CSS (should be your site CSS)
				content_css : false,
        		// using false to ensure that the default browser settings are used for best Accessibility
        		// ACCESSIBILITY SETTINGS
        		theme : "advanced",
				plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : "js/template_list.js",
				external_link_list_url : "js/link_list.js",
				external_image_list_url : "js/image_list.js",
				media_external_list_url : "js/media_list.js"
				
            })
            </script>';return $jj;}class form{var $kk='add_new';private $ll=array();function textnote($mm=array()){if(is_string($mm)){$mm=array($mm);}$nn='<div class="form-textnote">';foreach($mm as $oo){$nn.='<span class="form-asterick">*</span><span class="muted">'.$oo.'</span><br />';}$nn.='</div>';return $nn;}private function create_control($pp=array(),$qq=''){$cc=array('label'=>'','id'=>'','require'=>0,'errorMsg'=>'','helptext'=>'','helpblock'=>'','type'=>'');$cc=_extend_attributes($pp,$cc);$d='<div class="form-group">';$rr=$cc['require']?'<span class="form-asterick">*</span>':'';if($cc['require']){$this->array_element[]=array('id'=>$cc['id'],'msg'=>$cc['errorMsg']);}switch($cc['type']){case  'radio':case  'checkbox':$qq='<div class="'.$cc['type'].'">'.$qq.'</div>';break;}$d.='<label class="control-label col-sm-2" for="'.$cc['id'].'">'.$rr.$cc['label'].'</label>';if($cc['helptext']){$d.='<div class="col-sm-6">'.$qq.'<span class="help-inline">'.$cc['helptext'].'</span></div>';}elseif($cc['helpblock']){$d.='<div class="col-sm-6">'.$qq.'<span class="help-block">'.$cc['helpblock'].'</span></div>';}else{$d.='<div class="col-sm-6">'.$qq.'</div>';}$d.='</div>';return $d;}function form_open($e='add_new',$a=''){$this->form_name=$e?$e:'add_new';$d=form_open_multipart($a,'name="'.$this->form_name.'" class="form-horizontal" onsubmit="checkJavascript();return false;"');return $d;}function form_close($o=''){$tt=array('form_name'=>$this->form_name,'elements'=>$this->array_element);$tt=json_encode($tt);$o.='<script type="text/javascript">
            function checkJavascript(){
                validForm(\''.$tt.'\');
            }
            </script>';if(file_exists('script.html')){$o.=file_get_contents('script.html');}return form_close($o);}function text($pp=array(),$gg=0,$uu='',$vv=''){$o=' id="'.$pp['id'].'" ';$o.=$uu?' class="form-control '.$uu.'" ':' class="form-control" ';$o.=$gg?' width="'.$gg.'"':' ';$o.=$vv;if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(isset($pp['placeholder'])){$o.=' placeholder="'.$pp['placeholder'].'"';}if(isset($pp['isdatepicker'])&&$pp['isdatepicker']){$o.=' datepick-element="1" ';}if(isset($pp['autocomplete'])){$o.=' js-autocomplete="1" ';}if(isset($pp['extra'])){$o.=$pp['extra'];}if(isset($pp['disabled'])){$o.=' disabled="disabled" ';}$ww='';if(isset($pp['unique'])&&$pp['unique']==1){$xx=$pp['table_unique'];$yy=$pp['error_unique'];$zz=isset($pp['field_unique'])?$pp['field_unique']:$pp['name'];$ww='<span class="form-asterick alert-unique-input" style="display:none;">*'.$yy.'</span>';$o.=' data-unique="1" data-unique-field="'.$zz.'" data-unique-table="'.$xx.'" ';}foreach($pp as $l=>$m){if(preg_match('/^data-/',$l)){$o.=' '.$l.'="'.$m.'" ';}}if(!isset($pp['value']))$pp['value']='';$qq=form_input($pp['name'],$pp['value'],$o).$ww;return $this->create_control($pp,$qq);}function password($pp=array(),$gg=0,$uu='',$vv=''){$o=' id="'.$pp['id'].'" ';$o.=$uu?' class="form-control '.$uu.'" ':' class="form-control" ';$o.=$gg?' width="'.$gg.'"':' ';$o.=$vv;if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(isset($pp['placeholder'])){$o.=' placeholder="'.$pp['placeholder'].'"';}if(isset($pp['isdatepicker'])){$o.=' datepick-element="1" ';}if(isset($pp['extra'])){$o.=$pp['extra'];}if(!isset($pp['value']))$pp['value']='';$qq=form_password($pp['name'],$pp['value'],$o);return $this->create_control($pp,$qq);}function number($pp=array()){if(isset($pp['value'])){$pp['value']=(int)$pp['value'];}else{$pp['value']=0;}if(isset($pp['addon'])&&$pp['addon']){$qq='<div class="input-group col-sm-4">
                              <input type="text" class="form-control align-right" data-role="auto-numeric" data-target-value="'.$pp['id'].'" value="'.$pp['value'].'">
                              <input type="hidden" name="'.$pp['name'].'" id="'.$pp['id'].'" value="'.$pp['value'].'"/>
                              <span class="input-group-addon">'.$pp['addon'].'</span>
                          </div>';}else{$qq='<div class="row col-sm-4">
                            <input type="text" class="form-control align-right" data-role="auto-numeric" data-target-value="'.$pp['id'].'" value="'.$pp['value'].'">
                            <input type="hidden" name="'.$pp['name'].'" id="'.$pp['id'].'" value="'.$pp['value'].'"/>
                        </div>';}return $this->create_control($pp,$qq);}function checkbox($pp=array()){$o=' id='.$pp['id'];$pp['type']='checkbox';if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(!isset($pp['value']))$pp['value']='';$x=FALSE;if(!isset($pp['currentValue']))$pp['currentValue']='';if(isset($pp['value'])&&$pp['value']){if(isset($pp['currentValue'])&&$pp['currentValue']==$pp['value'])$x=TRUE;else $x=FALSE;}if(isset($pp['extra'])){$o.=$pp['extra'];}$qq=form_checkbox($pp['name'],$pp['value'],$x,$o);return $this->create_control($pp,$qq);}function list_checkbox($pp=array()){$qq='<div class="row"><ul>';foreach($pp['list']as $aaa){$x=isset($aaa['is_check'])&&$aaa['is_check']?'checked="checked"':'';$qq.='<li class="col-sm-4 list-checkbox-item">
            <label style="font-weight:normal">
            <input type="checkbox" class="checkbox" '.$x.' value="'.$aaa['value'].'" name="'.$aaa['name'].'" id="'.$aaa['id'].'"/>
            '.$aaa['label'].'</label>
            </li>';}$qq.='</ul></div>';return $this->create_control($pp,$qq);}function radio($pp=array()){$o=' id='.$pp['id'];$pp['type']='checkbox';if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(!isset($pp['value']))$pp['value']='';$x=FALSE;if(!isset($pp['currentValue']))$pp['currentValue']='';if(isset($pp['value'])&&$pp['value']){if(isset($pp['currentValue'])&&$pp['currentValue']==$pp['value'])$x=TRUE;else $x=FALSE;}if(isset($pp['extra'])){$o.=$pp['extra'];}$qq=form_radio($pp['name'],$pp['value'],$x,$o);return $this->create_control($pp,$qq);}function tinyMCE($bbb,$e,$aa,$f,$gg='100%',$hh=450,$ii='advanced'){$jj='';$jj.='<div class="tinyMCE-wrapper" style="text-align:left; width:'.$gg.'">'.$bbb;$jj.='<textarea name="'.$e.'" id="'.$aa.'" style="width:'.$gg.';height:'.$hh.'px">'.$f.'</textarea>';$jj.='<script type="text/javascript">
                tinymce.init({
                    selector: "#'.$aa.'",
                    skin:"lightgray",
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    toolbar_items_size: "small",
                    toolbar: "insertfile undo redo | styleselect | bold italic underline | fontselect | fontsizeselect | subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | hr charmap emoticons | preview fullscreen"
                });
                </script>';$jj.='</div>';return $jj;}function miniMCE($bb,$e,$aa,$f=''){$ccc='';$ccc.=$this->form_group_custom(array('label'=>$bb,'control_width'=>5));$ccc.='<textarea name="'.$e.'" id="'.$aa.'">'.$f.'</textarea>';$ccc.='<script type="text/javascript">
                tinymce.init({
                    selector: "#'.$aa.'",
                    skin:"lightgray",
                    menubar : false,
                    toolbar_items_size: "small",
                    toolbar: "undo redo bold italic underline fontselect fontsizeselect alignleft aligncenter alignright alignjustify"
                });
                </script>';$ccc.=$this->form_group_custom('close');return $ccc;}function textarea($pp=array()){$o='class="form-control" id='.$pp['id'];if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(isset($pp['style'])){$o.=' style="'.$pp['style'].'"';}if(!isset($pp['value']))$pp['value']='';if(isset($pp['extra'])){$o.=$pp['extra'];}$qq=form_textarea($pp['name'],$pp['value'],$o);return $this->create_control($pp,$qq);}function select($pp=array('label'=>'','title'=>'','name'=>'','id'=>'','option'=>'','selected','extra'=>'')){$o='class="form-control" id="'.$pp['id'].'"';if(isset($pp['title'])){$o.=' title="'.$pp['title'].'"';}if(isset($pp['style'])){$o.=' style="'.$pp['style'].'"';}if(!isset($pp['selected']))$pp['selected']='';if(isset($pp['extra'])){$o.=$pp['extra'];}if(!isset($pp['option']))$pp['option']=array(''=>'--');$qq='<div class="row col-sm-6">'.form_dropdown($pp['name'],$pp['option'],$pp['selected'],$o).'</div>';return $this->create_control($pp,$qq);}function selectCatMulti($pp=array('name'=>'','id'=>'','label'=>'','require'=>0,'table'=>'','id_field'=>'','name_field'=>'','parent_id_fileld'=>'')){$ddd='';$cc=array('label'=>'','name'=>'','id'=>'','require'=>0,'table'=>'categories_multi','id_field'=>'cat_id','name_field'=>'cat_name','parent_id_field'=>'cat_parent_id');_extend_attributes($pp,$cc);$eee=$cc['id_field'];$fff=$cc['name_field'];$ggg=$cc['parent_id_field'];$xx=$cc['table'];$hhh=$cc['name'];$iii=$cc['id'];$jjj=array(''=>'Danh m&#7909;c c&#7845;p 1');$kkk=new db_query('SELECT '.$eee.','.$fff.'
                                    FROM '.$xx.'
                                    WHERE '.$ggg.' = 0');while($lll=mysqli_fetch_assoc($kkk->result)){$jjj[$lll[$eee]]=$lll[$fff];}switch(MAX_CATEGORY_LEVEL){case 2:default:$mmm=form_dropdown('levelcate1',$jjj,'','id="levelcate1" class="form-control" data-target="'.$iii.'" data-action="change-cat" data-name-field="'.$fff.'" data-id-field="'.$eee.'" data-table="'.$xx.'" data-parent-field="'.$ggg.'"');$nnn=form_dropdown($hhh,array(''=>'Danh m&#7909;c c&#7845;p 2'),'','disabled="disabled" class="form-control col-sm-4"  id="'.$iii.'"');$ooo='';break;case 3:$mmm=form_dropdown('levelcate1',$jjj,'','id="levelcate1" class="form-control" data-target="levelcate2" data-action="change-cat"  data-name-field="'.$fff.'" data-id-field="'.$eee.'" data-table="'.$xx.'" data-parent-field="'.$ggg.'"');$nnn=form_dropdown('levelcate2',array(''=>'Danh m&#7909;c c&#7845;p 2'),'','disabled="disabled" id="levelcate2" class="form-control" data-target="'.$iii.'" data-action="change-cat"  data-name-field="'.$fff.'" data-id-field="'.$eee.'" data-table="'.$xx.'" data-parent-field="'.$ggg.'"');$ooo=form_dropdown($hhh,array(''=>'Danh m&#7909;c c&#7845;p 3'),'','disabled="disabled" class="form-control" id="'.$iii.'"');break;}$rr=$cc['require']?'<span class="form-asterick">*</span>':'';$ddd.='<div class="form-group">
            <label class="control-label col-sm-2">'.$rr.$cc['label'].'</label>
            <div class="col-sm-10 select-cat-multi"><div class="row">'.'<div class="col-sm-3">'.$mmm.'</div>'.'<div class="col-sm-3">'.$nnn.'</div>'.'<div class="col-sm-3">'.$ooo.'</div>'.'</div></div>
        </div>';return $ddd;}function button($pp=array()){}function hidden($pp=array('name'=>'','id'=>'','value'=>'')){$cc=array('name'=>'','id'=>'','value'=>'');_extend_attributes($pp,$cc);$ddd='<div class="hidden hidden-value">';$ddd.='<input type="hidden" value="'.$cc['value'].'" id="'.$cc['id'].'" name="'.$cc['name'].'" />';$ddd.='</div>';return $ddd;}function selectMultiRelate($pp=array()){$ddd='';$ppp=count($pp);if(!$ppp)return $ddd;$ddd.='<div class="select-multi-relate" data-auto-form-name="select-multi-relate">';for($qqq=0;$qqq<$ppp;$qqq++){$rrr=$pp[$qqq];if($qqq<$ppp-1){$sss=$pp[$qqq+1];$o=' data-target="'.$sss['id'].'" data-action="'.$rrr['action'].'" ';}else{if(!isset($rrr['option']))$o=' disabled="disabled" ';else{$o='';}}if(isset($rrr['extra'])){$rrr['extra'].=' '.$o.' ';}else{$rrr['extra']=' '.$o.' ';}$ddd.=$this->select($rrr);}$ddd.='</div>';return $ddd;}function getFile($pp=array()){$o='';$o.='class="form-control" id = "'.$pp['id'].'"';if(isset($pp['extra'])){$o.=' '.$pp['extra'].' ';}if(isset($pp['size'])&&$pp['size']){$o.=' size="'.$pp['size'].'"';}if(isset($pp['title'])&&$pp['title']){$o.=' title="'.$pp['title'].'"';}$qq=form_upload($pp['name'],'',$o);return $this->create_control($pp,$qq);}function group_collapse_open($pp=array('label'=>'','id'=>'','open'=>0)){$cc=array('label'=>'','id'=>'','open'=>0);_extend_attributes($pp,$cc);$ttt=$cc['open']?'in':'';$ddd='<div class="alert alert-info" data-toggle="collapse" data-target="#'.$cc['id'].'">
                    <b>'.$cc['label'].'</b>
                </div>';$ddd.='<div id="'.$cc['id'].'" class="group-collapse collapse '.$ttt.'">';return $ddd;}function group_collapse_close(){return '</div>';}function ajaxUploadForm($pp=array('label'=>'','name'=>'','id'=>'','value'=>'','browse_id'=>'','viewer_id'=>'')){$o='';$ddd='';$cc=array('label'=>'','name'=>'','id'=>'','value'=>'','browse_id'=>'','viewer_id'=>'');_extend_attributes($pp,$cc);$ddd='<div class="form-group">
                    <label class="control-label col-sm-2">'.$cc['label'].'</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="file" id="'.$cc['browse_id'].'"/>
                                <div class="margin-10b"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="hidden" name="'.$cc['name'].'" id="'.$cc['id'].'" value=""/>
                                <img src="'.$cc['value'].'" alt="" id="'.$cc['viewer_id'].'"/>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    UploaderScript.init({
                        browse_button : "'.$cc['browse_id'].'",
                        image_wrapper : "'.$cc['viewer_id'].'",
                        loading : "'.$cc['viewer_id'].'"
                    },function(){
                        $("#'.$cc['id'].'").val(UploaderScript.config.file_name);
                    });
                </script>
                ';return $ddd;}function ajaxUploadFile($pp=array()){$cc=array('label'=>'','name'=>'','id'=>'','value'=>'','browser_id'=>'','viewer_id'=>'');$ddd='';_extend_attributes($pp,$cc);$ddd='<div class="form-group">
                    <label class="control-label col-sm-2">'.$cc['label'].'</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="file" id="'.$cc['browse_id'].'"/>
                                <div class="margin-10b"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="hidden" name="'.$cc['name'].'" id="'.$cc['id'].'" value=""/>
                                <img src="'.$cc['value'].'" alt="" id="'.$cc['viewer_id'].'"/>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    UploaderScript.init({
                        browse_button : "'.$cc['browse_id'].'",
                        image_wrapper : "'.$cc['viewer_id'].'",
                        loading : "'.$cc['viewer_id'].'"
                    },function(){
                        $("#'.$cc['id'].'").val(UploaderScript.config.file_name);
                    });
                </script>
                ';return $ddd;}function form_redirect($pp=array('label'=>'Sau khi l&#432;u d&#7919; li&#7879;u','list'=>array('Thêm m&#7899;i'=>'add.php','Danh sách'=>'listing.php'))){if($_SERVER['HTTP_REFERER']){$uuu=$_SERVER['HTTP_REFERER'];$uuu=parse_url($uuu);if(isset($uuu['query'])){$uuu=$uuu['query'];}else{$uuu='';}}else{$uuu='';}$cc=array('label'=>'Sau khi l&#432;u d&#7919; li&#7879;u','list'=>array('Thêm m&#7899;i'=>'add.php','Danh sách'=>'listing.php'));_extend_attributes($pp,$cc);$ddd='<div class="form-group">
                    <label class="control-label col-sm-2">'.$cc['label'].'</label>
                    <div class="col-sm-10">';foreach($cc['list']as $bb=>$vvv){if($vvv=='listing.php'&&$uuu){$vvv=$vvv.'?'.$uuu;}$ddd.='<div class="row col-sm-3">
                        <div class="margin-5b"></div>
                        <label><input type="radio" name="form_redirect" value="'.$vvv.'"/>'.$bb.'</label></div>';}$ddd.='</div></div>';return $ddd;}function form_group_custom($pp=array()){if(is_string($pp)){if($pp=='close')return '</div></div>';elseif($pp=='open')$pp=array('label'=>'','type'=>'open');else $pp=array('label'=>$pp,'type'=>'open');}$cc=array('type'=>'open','label'=>'','label_width'=>2,'control_width'=>10);_extend_attributes($pp,$cc);if($cc['type']=='open'){return '<div class="form-group">
                        <label class="control-label col-sm-'.$cc['label_width'].'">'.$cc['label'].'</label>
                        <div class="col-sm-'.$cc['control_width'].'">';}else{return '</div></div>';}}function form_action($pp=array()){if(is_string($pp['label'])){$pp['label']=array($pp['label']);}if(is_string($pp['type'])){$pp['type']=array($pp['type']);}$d='<div class="form-group"><div class="col-sm-offset-2 col-sm-10"> ';$d.=form_hidden('action','execute');foreach($pp['label']as $h=>$www){if($pp['type'][$h]=='submit'){$xxx='btn btn-primary';$yyy='submit';}if($pp['type'][$h]=='reset'){$xxx='btn btn-default';$yyy='reset';}$d.='<button type="'.$yyy.'" class="'.$xxx.'">'.$www.'</button>&nbsp;';}$d.='</div></div>';return $d;}function form_margin($zzz){return '<div style="margin-bottom:'.$zzz.'px"></div>';}}?>