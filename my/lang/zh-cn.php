<?php
$lang->my->common = '我的地盘';
/* 方法列表。*/
$lang->my->index          = '首页';
$lang->my->todo           = '我的待办';
$lang->my->task           = '我的任务';
$lang->my->bug            = '我的Bug';
$lang->my->testTask       = '我的版本';
$lang->my->testCase       = '我的用例';
$lang->my->story          = '我的需求';
$lang->my->myProject      = "我的{$lang->projectCommon}";
$lang->my->team           = '我的团队';
$lang->my->basicinfo      = '基本信息';
$lang->my->burninfo       = '燃尽图';
$lang->my->msginfo        = '留言板';
$lang->my->otherinfo      = '其他待定';

$lang->my->profile        = '个人资料';
$lang->my->dynamic        = '我的动态';
$lang->my->editProfile    = '修改档案';
$lang->my->changePassword = '修改密码';
$lang->my->history        = '我的历史记录';
$lang->product->name2     = '产品';
$lang->project->name2     = '项目';

$lang->my->taskMenu = new stdclass();
$lang->my->taskMenu->assignedToMe = '指派给我';
$lang->my->taskMenu->openedByMe   = '由我创建';
$lang->my->taskMenu->finishedByMe = '由我完成';
$lang->my->taskMenu->closedByMe   = '由我关闭';
$lang->my->taskMenu->canceledByMe = '由我取消';
$lang->my->taskMenu->all          = '所有';

$lang->my->storyMenu = new stdclass();
$lang->my->storyMenu->assignedToMe = '指派给我';
$lang->my->storyMenu->openedByMe   = '由我创建';
$lang->my->storyMenu->reviewedByMe = '由我评审';
$lang->my->storyMenu->closedByMe   = '由我关闭';

$lang->my->home = new stdclass();
$lang->my->home->latest        = '最新动态';
$lang->my->home->action        = "%s, %s <em>%s</em> %s <a href='%s'>%s</a>。";
$lang->my->home->projects      = $lang->projectCommon;
$lang->my->home->products      = $lang->productCommon;
$lang->my->home->projectHome   = "访问{$lang->projectCommon}主页";
$lang->my->home->productHome   = "访问{$lang->productCommon}主页";
$lang->my->home->createProject = "创建一个{$lang->projectCommon}";
$lang->my->home->createProduct = "创建一个{$lang->productCommon}";
$lang->my->home->help          = "<a href='http://www.zentao.net/help-read-79236.html' target='_blank'>帮助文档</a>";
$lang->my->home->noProductsTip = "这里还没有{$lang->productCommon}。";

$lang->my->form = new stdclass();
$lang->my->form->lblBasic   = '基本信息';
$lang->my->form->lblContact = '联系信息';
$lang->my->form->lblAccount = '帐号信息';

$lang->my->teammember    = "团队成员";
$lang->my->mybug         = "我的Bug";
$lang->my->mytask        = "我的任务";
$lang->my->curWeather    = "当前天气";
$lang->my->sprinttask    = "sprinttask";   
$lang->my->sprintbug     = "sprintbug";
$lang->my->weatheredit   = "weatheredit";
$lang->my->sprintTeam    = "sprintTeam";
$lang->my->weather       = "天气";
$lang->my->weatherRemark = "备注";
$lang->my->weatheredit   = '编辑天气';
$lang->my->computeBurn   = '更新';
$lang->my->allbug        = '查看所有Bug';
$lang->my->alltask       = '查看所有任务';

$lang->my->weatherLis['sunny']     = 5;
$lang->my->weatherLis['cloudy']    = 4;
$lang->my->weatherLis['windy']     = 3;
$lang->my->weatherLis['rainy']     = 2;
$lang->my->weatherLis['thunder']   = 1;

$lang->my->weatherRes[5]     = 'sunny';
$lang->my->weatherRes[4]     = 'cloudy';
$lang->my->weatherRes[3]     = 'windy';
$lang->my->weatherRes[2]     = 'rainy';
$lang->my->weatherRes[1]     = 'thunder';

$lang->weather               = '<strong class="weather_title">Sprint</strong> 天气 :';
$lang->pleaseGiveScore       = '暂无，请投票';
$lang->score                 = '分';
$lang->myScore               = '我的投票：';

$lang->my->delayWarn         = '截止时间已过，系统已自动将截止时间延长到今天！如果本Sprint已完成，请及时关闭！';
$lang->my->doneWarn          = '的所有任务都已经做完啦，请及时将该sprint状态改为关闭！';