<?php

class CategorysAction extends MainAction {

    //问答分类列表管理
    public function index() {

        $this->display();
    }

    //获取问答分类列表数据
    public function getList() {
        $_q = getParams();
        $obj = new stdClass();
        $obj->name = $_q->name;
        $obj->status = $_q->status;
        $obj->limit = $_q->limit;

        $result = D("Pro_categorys")->getList($obj);
        $o = (object) $result;
        echo json_encode($o);
    }

    //新增问答类别
    public function add() {
        $this->display();
    }

    //编辑与查看问答类别
    public function edit() {
        $_q = getParams();
        if (intval($_q->id) > 0) {
            $categorys_result = M("Pro_categorys")->find($_q->id);
            $this->assign("tempData", $categorys_result);
        }
        $this->display();
    }

    //保存问答类别
    public function save() {
        $_q = getParams();
        $time = time();
        $ip = get_client_ip();
        $users = $this->users;
        $data = array(
            'name' => $_q->name,
            'summary' => $_q->summary,
            'status' => $_q->status,
            'addtime' => $time,
            'uptime' => $time,
            'updateip' => $ip,
            'op_user' => $users['id']
        );

        $Pro_categorys = M("Pro_categorys");
        if ($_q->id > 0) {
            $data['id'] = $_q->id;
            $result = $Pro_categorys->save($data);
        } else {
            $result = $Pro_categorys->add($data);
        }
        echo $result;
    }

    //删除文章
    public function delete() {
        $_q = getParams();
        $result = 0;
        if (intval($_q->id) > 0) {
            $result = M("Pro_categorys")->where(array('id' => $_q->id))->delete();
        }
        echo $result;
    }

}
