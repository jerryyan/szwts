<?php
class AreaAction extends MainAction{

	//获取选择的地区菜单
	public function getAreaHtml($obj){
		$area = M("Area");
		if(intval($obj->id)){
			$area_one = $area->find($obj->id);
			$area_list = $area->where(array('pid'=>$area_one['pid']))->select();
			$city_one = $area->find($area_one['pid']);
			$city_list = $area->where(array('pid'=>$city_one['pid']))->select();
			$province_one = $area->find($city_one['pid']);
			$province_list = $area->where(array('pid'=>0))->select();
			$provinces = '<select name="province">';
			$provinces .= '<option value="0">--请选择--</option>';
			foreach ($province_list as $v){
				$selected = "";
				if($province_one['id']==$v['id']){
					$selected = " selected='selected' ";
				}
				$provinces .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
			}
			$provinces .= '</select>';
			
			$citys = '<select name="city">';
			$citys .= '<option value="0">--请选择--</option>';
			foreach ($city_list as $v){
				$selected = "";
				if($city_one['id']==$v['id']){
					$selected = " selected='selected' ";
				}
				$citys .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
			}
			$citys .= '</select>';
			
			$areas = '<select name="area">';
			$areas .= '<option value="0">--请选择--</option>';
			foreach ($area_list as $v){
				$selected = "";
				if($area_one['id']==$v['id']){
					$selected = " selected='selected' ";
				}
				$areas .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
			}
			$areas .= '</select>';
			$html = $provinces.$citys.$areas;
		}else{
			$province_list = $area->where(array('pid'=>0))->select();
			$html = '<select name="province">';
			$html .= '<option value="0">--请选择--</option>';
			foreach ($province_list as $v){
				$html .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
			}
			$html .= '</select>';
		}
		return $html;
	}
}