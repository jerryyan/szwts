<?php

class AnswerAction extends MainAction {

    public function index() {
        $_q = getParams();
        $categorys_result = M("Pro_categorys")->where("status=1")->select();
        $this->assign("categorys", $categorys_result);
        $obj = new stdClass();
        $type = explode("_", $_q->catid);

        if (empty($type[0])) {
            $type[0] = 0;
        }
        if (empty($type[1])) {
            $type[1] = 0;
        }
        $this->assign("catid", $type[0]);
        $this->assign("type", $type[1]);
        $obj->keyword = $_q->keyword;
        $obj->catid = $type[0];
        $obj->type = $type[1];
        $Procontents_result = D("Pro_contents")->getList($obj);
        import("ORG.Util.Page");
        // 实例化分页类 
        $p = new Page($Procontents_result['total'], 10);
        $list = array_slice($Procontents_result['rows'], $p->firstRow, $p->listRows);
        $this->assign("Procontents", $list);
        // 分页显示输出 
        $page = $p->show();
        $this->assign("page", $page);
        // 最热
        $top10 = M("Pro_contents")->field("id,title")->where("status=1")->order("pageviews desc")->limit("0,10")->select();
        $this->assign("top10", $top10);
        $this->display();
    }

    //问题详情
    public function detail() {
        $users = $this->users;
        $_q = getParams();
        if (intval($_q->id) > 0) {
            $tp = C('DB_PREFIX');
            $contents_result = M("Pro_contents")->table("{$tp}pro_contents as a,{$tp}user as b")->field("id,title,a.user_id,content,is_recommend,pageviews,answernum,adopt_id,from_unixtime(a.uptime) as uptime,b.username")->where("a.user_id=b.user_id and a.id=$_q->id")->find();
            $answers_result = M("Pro_answers")->table("{$tp}pro_answers as a,{$tp}user as b")->field("id,content,is_adopt,from_unixtime(a.uptime) as uptime,b.username")->where("a.user_id=b.user_id and status=1 and a.con_id=$_q->id")->select();
            $thisanswer = M("Pro_answers")->where("con_id=$_q->id and user_id={$users['user_id']}")->find();
            $data['id'] = $_q->id;
            $data['pageviews'] = $contents_result['pageviews'] + 1;
            $data['answernum'] = count($answers_result);
            M("Pro_contents")->save($data);
            $this->assign("tempData", $contents_result);
            $this->assign("answersData", $answers_result);
            $this->assign("thisanswer", $thisanswer);
            $this->assign("answernum", $data['answernum']);
            $this->assign("users", $users);
        }
        $this->display();
    }

    //添加问题
    public function add() {
        $this->checkLogin();
        $categorys_result = M("Pro_categorys")->where("status=1")->select();
        $this->assign("categorys", $categorys_result);
        $this->display();
    }

    //保存问题数据
    public function save() {
        $_q = getParams();
        $time = time();
        $ip = get_client_ip();
        $users = $this->users;
        $data = array(
            'user_id' => $users['user_id'],
            'cat_id' => $_q->cate,
            'title' => $_q->title,
            'content' => $_q->content,
            'addtime' => $time,
            'addip' => $ip,
            'uptime' => $time,
            'upip' => $ip,
        );
        $Pro_contents = M("Pro_contents");
        if ($_q->id > 0) {
            $data['id'] = $_q->id;
            $result = $Pro_contents->save($data);
        } else {
            $result = $Pro_contents->add($data);
        }
        echo $result;
    }

    //保存回答数据
    public function answersave() {
        $_q = getParams();
        $time = time();
        $ip = get_client_ip();
        $users = $this->users;
        $data = array(
            'user_id' => $users['user_id'],
            'con_id' => $_q->con_id,
            'content' => $_q->content,
            'uptime' => $time,
            'upip' => $ip,
        );
        $Pro_answers = M("Pro_answers");
        if ($_q->id > 0) {
            $data['id'] = $_q->id;
            $result = $Pro_answers->save($data);
        } else {
            $data['addtime'] = $time;
            $data['addip'] = $ip;
            $result = $Pro_answers->add($data);
        }
        echo $result;
    }

    //检查登陆
    public function checkLogin() {
        $users = $_SESSION['Home_user'];
        if (empty($users)) {
            $this->redirect("/Login");
            die();
        }
    }

}
