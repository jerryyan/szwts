<?php

class NewsAction extends MainAction {

    // 新闻中心统一页面
    public function index() {
        //新闻中心左边列表
        $_q = getParams();
        if (!intval($_q->id)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        $modules_id = $_q->id;
        $articles = M("Articles");
        // 计算总数 
        $article_result = $articles->field("count(1) as num")->where("modules_id='%d' and status=0", $modules_id)->find();
        $num = $article_result['num'];
        if ($num == 0) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        // 导入分页类 
        import("ORG.Util.Page");
        // 实例化分页类 
        $p = new Page($num, 10);
        // 分页显示输出 
        $page = $p->show();
        $list = $articles->field("id,title,thumbnail,summary,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit($p->firstRow, $p->listRows)->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        // 导航输出
        $modules = M("Modules");
        $modules_result = $modules->field("id,name")->find($modules_id);
        $nav_str = '<a href="/">首页</a> >> <a href="javascript:void(0);">' . $modules_result['name'] . '</a>';
        $this->assign("nav", $nav_str);
        switch ($modules_result['id']) {
            case 7:
                $pageTitle = "投资攻略-p2p贷款-网投所";
                $pageKeywords = "网投所,p2p贷款,创业贷款,理财方法,理财规划,个人小额贷款,网贷平台排名,投资理财知识,项目融资,融资方式,理财投资,个人理财规划,理财网站,短期理财产品";
                $pageDes = "网投所不仅能为您选出行业最优秀、最安全的P2P网贷平台，还能为您奉上网贷行业资深投资人的理财攻略，做您最专业的理财咨询师";
                break;
            case 8:
                $pageTitle = "行业动态-P2P网络借贷-网投所";
                $pageKeywords = "网投所,p2p网络借贷,创业投资,网贷新闻,理财网,小额投资,商业贷款,网络贷款,债券转让,企业融资";
                $pageDes = "网投所为您网罗行业内最新鲜、最全面的资讯、数据，为您的投资理财提供最为专业、宝贵的意见";
                break;
            case 9:
                $pageTitle = "网址公告-网络投资理财平台-网投所";
                $pageKeywords = "网投所,投资融资,网络理财产品,网络投资理财平台,网络小额贷款平台";
                $pageDes = "网投所为您及时播报网贷行业动态趋势及资讯，让您及时了解平台动向及投资项目信息";
                break;
            default :
                $pageTitle = $modules_result['name'];
                $pageKeywords = $modules_result['name'];
                $pageDes = $modules_result['name'];
        }

        $this->assign('pageTitle', $pageTitle);
        $this->assign('pageKeywords', $pageKeywords);
        $this->assign('pageDes', $pageDes);

        // 热门阅读
        $modules_result = $modules->field("group_concat(id) as ids")->where("(nid='raiders' or nid='dynamic') and is_hide=0 and is_list=1")->find();
        $hotlist = $articles->field("id,title,thumbnail,addtime")->where("modules_id in({$modules_result['ids']}) and status=0")->order("click_num desc")->limit(5)->select();
        $this->assign("hotlist", $hotlist);

        $this->display();
    }

    //新闻中心正文页面
    public function details() {
        $_q = getParams();
        if (!intval($_q->id)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        //新闻正文内容
        $article_id = $_q->id;
        $articles = M("Articles");
        $articles_result = $articles->field("id,modules_id,title,summary,content,addtime")->where("id='%d' and status=0", $article_id)->find();
        if (empty($articles_result)) {
            $this->error("您的操作有误", "javascript:history.go(-1);");
            exit;
        }
        $this->assign("articles_result", $articles_result);
        // 导航输出
        $modules = M("Modules");
        $modules_result = $modules->field("id,name")->find($articles_result['modules_id']);
        $nav_str = '<a href="/">首页</a> >> <a href="/News/index/id/' . $modules_result['id'] . '.html">' . $modules_result['name'] . '</a> >> <a href="javascript:void(0);">正文</a>';
        $this->assign("nav", $nav_str);
        // 热门阅读
        $modules_result = $modules->field("group_concat(id) as ids")->where("(nid='raiders' or nid='dynamic') and is_hide=0 and is_list=1")->find();
        $hotlist = $articles->field("id,title,thumbnail,addtime")->where("modules_id in({$modules_result['ids']}) and status=0")->order("click_num desc")->limit(5)->select();
        $this->assign("hotlist", $hotlist);
        $this->assign('pageTitle', $articles_result['title']);
        $this->assign('pageKeywords',"网投所,p2p贷款平台,p2p投资理财平台,p2p网贷理财,p2p网贷平台,贷款网站,网贷平台,网络借贷,网络投资");
        $this->assign('pageDes', "网投所，网贷投资人的首选交易所，为投资人甄选国内最安全的P2P平台，提供多样化的p2p理财服务，为您的投资收益保驾护航");
        // 更新浏览次数
        $obj = new stdClass();
        $obj->id = $article_id;
        D("Articles")->updateViewNum($obj);

        $this->display();
    }

}
