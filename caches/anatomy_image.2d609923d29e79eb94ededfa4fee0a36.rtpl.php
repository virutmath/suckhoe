<?php if(!class_exists('raintpl')){exit;}?><img src="<?php echo $anatomy_data['image'];?>" alt="" usemap="#Map"  class="mapper"/>
<map name="Map" id="Map">
    <?php $counter1=-1; if( isset($anatomy_data['data']) && is_array($anatomy_data['data']) && sizeof($anatomy_data['data']) ) foreach( $anatomy_data['data'] as $key1 => $value1 ){ $counter1++; ?>
    <area alt="<?php echo $value1["ana_alt"];?>" title="<?php echo $value1["ana_title"];?>" data-id="<?php echo $value1["ana_id"];?>" data-link-detail="<?php echo $value1["link_detail"];?>" href="#" onclick="anatomy_human_show(this);return false;" id="map_female_<?php echo $value1["ana_id"];?>" shape="poly" coords="<?php echo $value1["ana_coords"];?>" />
    <?php } ?>
</map>