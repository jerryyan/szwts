<?php

class ProanswersAction extends MainAction {

    //回答类容列表管理
    public function index() {
        $this->display();
    }

    //获取回答类容列表数据
    public function getList() {
        $_q = getParams();
        $obj = new stdClass();
        $obj->name = $_q->name;
        $obj->status = $_q->status;
        $obj->limit = $_q->limit;

        $result = D("Pro_answers")->getList($obj);
        $o = (object) $result;
        echo json_encode($o);
    }

    //新增回答类容
//    public function add() {
//        $this->display();
//    }
    //编辑与查看回答类容
    public function edit() {
        $_q = getParams();
        if (intval($_q->id) > 0) {
            $procontents_result = M("Pro_answers")->find($_q->id);
            $this->assign("tempData", $procontents_result);
        }
        $this->display();
    }

    //保存回答类容
    public function save() {
        $_q = getParams();
        $time = time();
        $ip = get_client_ip();
        $data = array(
            'content' => $_q->content,
            'is_adopt' => $_q->is_adopt,
            'status' => $_q->status,
            'uptime' => $time,
            'upip' => $ip,
        );
        $Pro_answers = M("Pro_answers");
        if ($_q->id > 0) {
            $data['id'] = $_q->id;
            $result = $Pro_answers->save($data);
        } else {
            $result = $Pro_answers->add($data);
        }
        echo $result;
    }

    //删除文章
    public function delete() {
        $_q = getParams();
        $result = 0;
        if (intval($_q->id) > 0) {
           $result=M("Pro_answers")->where(array('id' => $_q->id))->delete();
        }
        echo $result;
    }

}
