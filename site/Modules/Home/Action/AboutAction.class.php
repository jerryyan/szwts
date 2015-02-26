<?php

class AboutAction extends MainAction {

    //关于我们统一页面
    public function index() {
        //关于我们左边菜单
        $module_name = strtolower(MODULE_NAME);
        $menus = M("Modules")->field("id,name,is_list,pid")->where("sorder like '%,1,%' and is_hide=0 and pid!=0")->order("porder asc")->select();
        $this->assign("menus", $menus);
        //右边内容
        $_q = getParams();
        $modules_id = 2;
        if (intval($_q->id)) {
            $modules_id = $_q->id;
        }
        $modules_result = M("Modules")->field("id,name,is_list")->where("id='{$modules_id}' and sorder like '%,1,%' and is_hide=0 and pid!=0")->find();
        if (empty($modules_result)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        $this->assign("modules_result", $modules_result);
        if (empty($modules_result['is_list'])) {//非列表模式
            $modules_content_result = M("Modules_content")->find($modules_id);
            $this->assign("content", $modules_content_result['content']);
        } else {//列表模式
            $article = M("Articles");
            // 计算总数 
            $article_result = $article->field("count(1) as num")->where("modules_id='%d' and status=0", $modules_id)->find();
            // 导入分页类 
            import("ORG.Util.Page");
            // 实例化分页类 
            $p = new Page($article_result['num'], 10);
            // 分页显示输出 
            $page = $p->show();
            $list = $article->field("id,title,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit($p->firstRow, $p->listRows)->select();

            $this->assign("page", $page);
            $this->assign("list", $list);
        }
        switch ($modules_result['id']) {
            case "2":
                $pageTitle = "使用必读-投资理财平台-网投所";
                $pageKeywords = "投资理财的选择,投资理财哪个好,投资理财平台";
                break;
            case "3":
                $pageTitle = "公司简介-投资理财网-网投所";
                $pageKeywords = "网投所,投资理财网,投资理财网站,投资理财项目";
                break;
            case "4":
                $pageTitle = "团队介绍-P2P网上贷款-网投所";
                $pageKeywords = "网投所,P2P网上贷款,贷款理财,贷款投资,贷款知识,个人贷款网";
                break;
            case "5":
                $pageTitle = "安全评级-民间借贷风险-网投所";
                $pageKeywords = "网投所,民间借贷风险,借贷公司,投融资平台,公司理财";
                break;
            case "6":
                $pageTitle = "联系我们-p2p管理-网投所";
                $pageKeywords = "网投所,p2p管理,互联网理财平台";
                break;
            default :
                $pageTitle = "关于我们-理财网站-网投所";
                $pageKeywords = "网投所,理财网站,理财计划,民间借贷公司,融资计划,债权融资";
        }
        $pageDes = "网投所是国领先的P2P网贷平台垂直搜索引擎，为现有的网贷平台提供P2P网贷平台排名，评级服务等；为投资者提供优质的投资理财产品";
        $this->assign('pageTitle', $pageTitle);
        $this->assign('pageKeywords', $pageKeywords);
        $this->assign('pageDes', $pageDes);
        $this->display();
    }

    //关于我们文章页面
    public function details() {
        $_q = getParams();
        if (!intval($_q->id)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        $modules = M("Modules");
        $menus = $modules->field("id,name,is_list,pid")->where("sorder like '%,1,%' and is_hide=0 and pid!=0")->order("porder asc")->select();
        $this->assign("menus", $menus);
        $article_result = M("Articles")->field("modules_id,title,content")->find($_q->id);
        if (empty($article_result)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        $modules_result = $modules->field("id,name")->where("id='%d'", $article_result['modules_id'])->find();
        $article_result['id'] = $modules_result['id'];
        $article_result['name'] = $modules_result['name'];
        $this->assign('pageTitle', $article_result['title']);
        $this->assign("article_result", $article_result);
        $this->display();
    }

}
