<?php

if(!empty($attr_map)){
	$html = "<option value=''>Please select attribute sets</option>";
	foreach($attr_map as $attr_mapRow){
		
		$attributeId	=	$attr_mapRow->id;
		$attributeName	=	$attr_mapRow->name;

		$html .= "<option value='".$attributeId."'>".$attributeName."</option>";		
	}
}else{
	$html = "<option value=''>Please select attribute sets</option>";
}

echo $html;
?>