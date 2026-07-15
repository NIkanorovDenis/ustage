<?
if(!function_exists("bxr_classic_build_tree")) {
	function bxr_classic_build_tree($mas, $ico = "N", $arColor = array("li" => "", "li_selected" => "", "ico_1" => "color", "ico_2" => "light"), $lvl=1) {

		if(!is_array($mas))
			return false;

		$s_result = "<ul>";

		$section_has_children = false;
		foreach($mas as $k => $v) {
			if(isset($v['CHILDREN'])) {
				$section_has_children = true;
				break;
			}
		}

		foreach($mas as $k => $v) {
			$s_ico = $s_ico_h = $icoClass = "";

			if($ico != "N") {

				if($arColor['ico_1']!=$arColor['ico_2']) {
					if(isset($v["ico_".$arColor['ico_2']]) && !empty($v["ico_".$arColor['ico_2']])) {
						if(is_numeric($v["ico_".$arColor['ico_2']])) {
							$img = CFile::ResizeImageGet($v["ico_".$arColor['ico_2']], array('width'=>15, 'height'=>15), BX_RESIZE_IMAGE_PROPORTIONAL, true);
						}
						else {
						   $img['src'] = $v["ico_".$arColor['ico_2']];
						}
						$s_ico_h = "<img class='bxr-ico-menu-hover-hover' src='" . $img['src'] . "'>";
					}
					elseif(!empty($v["ico_font"])){
						$s_ico_h = "<i class='bxr-ico-menu-hover-hover bxr-font-".$arColor['ico_2']." fa fa-fw " . $v["ico_font"] . "' ></i>";
					}
					elseif($ico == "ICO_DEFAULT") {
						//$s_ico_h = CFile::ShowImage(SITE_TEMPLATE_PATH. "/images/menu/default_ico_" . $arColor['ico_2'] . ".png", 15, 15, "class=bxr-ico-menu-hover-hover", "", false);
						$s_ico_h = "<i class='bxr-ico-menu-hover-hover bxr-font-".$arColor['ico_2']." fa fa-fw fa-angle-double-right' ></i>";
					}
					else {
						//$s_ico_h = "<span class='hover-not-ico'>&nbsp;</span>";
					}
				}

				$icoClass = "";
				if(!empty($s_ico_h))
					  $icoClass = "bxr-ico-menu-hover-default";

				if(isset($v["ico_".$arColor['ico_1']]) && !empty($v["ico_".$arColor['ico_1']])) {
					if(is_numeric($v["ico_".$arColor['ico_1']])) {
						$img = CFile::ResizeImageGet($v["ico_".$arColor['ico_1']], array('width'=>15, 'height'=>15), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					}
					else {
					   $img['src'] = $v["ico_".$arColor['ico_1']];
					}
					$s_ico = "<img class='".$icoClass."' src='" . $img['src'] . "'>";
				}
				elseif(!empty($v["ico_font"])){
					$s_ico = "<i class='".$icoClass." bxr-font-".$arColor['ico_1']." fa fa-fw " . $v["ico_font"] . "' ></i>";
				}
				elseif($ico == "ICO_DEFAULT") {
					//$s_ico = CFile::ShowImage(SITE_TEMPLATE_PATH. "/images/menu/default_ico_" . $arColor['ico_1'] . ".png", 15, 15, "class=".$icoClass, "", false);
					$s_ico = "<i class='".$icoClass." bxr-font-".$arColor['ico_1']." fa fa-fw fa-angle-double-right' ></i>";
				}
				else {
					//$s_ico = "<span class='hover-not-ico'>&nbsp;</span>";
				}

		}

			$li_class = $arColor['li'];
			$isSelected = "";
			if($v['SELECTED'] == 1) {
				$li_class .= " ". $arColor['li_selected'];
				$isSelected = " data-selected='1' ";
			}

			$fa_left_o = "";
			$li_a_class = "class='margin-no'";
			if($section_has_children) {
				$fa_left_o = "<i class='fa fa-circle-o'></i>";
				$li_a_class  = "";
				$addTouchSupport = ' bxr-c-touch ';
			} else {
				$addTouchSupport = '';
			}

			if(isset($v['CHILDREN']))
				$s_result .= "<li ".$isSelected." class='" . $li_class . $addTouchSupport . "' >" .
								"<a class='sub-item' href='" . $v['LINK'] . "'><i class='fa fa-angle-left'></i><span class='bxr-ico-hover-menu'>". $s_ico . $s_ico_h . "</span>" . $v['TEXT'] . "<i class='fa fa-angle-right'></i></a>"
									. bxr_classic_build_tree($v['CHILDREN'], $ico, $arColor, ($lvl+1)).
							"</li>";
			else
				$s_result .= "<li ".$isSelected." class='" . $li_class.  $addTouchSupport ."' >".
								"<a ".$li_a_class."  href='" . $v['LINK'] . "'>".$fa_left_o."<span class='bxr-ico-hover-menu'>". $s_ico . $s_ico_h . "</span>" . $v['TEXT'] . "</a>" .
							"</li>";

		}

		$s_result .= "</ul>";
		return $s_result;
	}
}