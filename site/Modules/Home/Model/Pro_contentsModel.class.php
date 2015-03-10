<?php

class Pro_contentsModel extends CommonModel {

    public function getList($obj) {
        $select = "a.id,b.name,a.user_id,a.title,a.status,a.content,a.addip,a.cat_id,a.upip,a.is_recommend,a.pageviews,a.answernum,a.adopt_id,from_unixtime(a.addtime) as atime,from_unixtime(a.uptime) as utime";
        $sql = " select $select from `{$this->tablePrefix}pro_contents` as a left join `{$this->tablePrefix}pro_categorys` as b on a.cat_id=b.id where 1=1 and a.status=1";
        if (!empty($obj->keyword)) {
            $sql .= " and a.title like '%{$obj->keyword}%' ";
        }
        if (!empty($obj->catid)) {
            $sql .= " and cat_id =$obj->catid";
        }

        if ($obj->type == 1) {
            $sql .= " and a.is_recommend=1 order by a.uptime desc ";
        } elseif ($obj->type == 2) {
            $sql .= " order by a.pageviews desc ";
        } elseif ($obj->type == 3) {
            $sql .= " order by a.answernum desc ";
        } else {
            $sql .= " order by a.uptime desc ";
        }

        $this->_ssql = $sql . $obj->limit;
        return $this->getDataList($select, $sql);
    }

}
