<?php
/**
 * The sprint module zh-cn file of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     sprint
 * @version     $Id: zh-cn.php 5094 2013-07-10 08:46:15Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
/* 字段列表。*/
$lang->sprint                = new stdclass();
$lang->sprint->common        = $lang->sprintcommon . '视图';
$lang->sprint->id            = $lang->sprintcommon . '编号';
$lang->sprint->company       = '所属公司';
$lang->sprint->fromsprint   = '所属' . $lang->sprintcommon;
$lang->sprint->iscat         = '作为目录';
$lang->sprint->type          = $lang->sprintcommon . '类型';
$lang->sprint->parent        = '上级' . $lang->sprintcommon;
$lang->sprint->name          = $lang->sprintcommon . '名称';
$lang->sprint->code          = $lang->sprintcommon . '代号';
$lang->sprint->begin         = '开始日期';
$lang->sprint->end           = '结束日期';
$lang->sprint->dateRange     = '起始日期';
$lang->sprint->to            = '至';
$lang->sprint->days          = '可用工作日';
$lang->sprint->day           = '天';
$lang->sprint->status        = $lang->sprintcommon . '状态';
$lang->sprint->statge        = '所处阶段';
$lang->sprint->pri           = '优先级';
$lang->sprint->desc          = $lang->sprintcommon . '描述';
$lang->sprint->openedBy      = '由谁创建';
$lang->sprint->openedDate    = '创建日期';
$lang->sprint->closedBy      = '由谁关闭';
$lang->sprint->closedDate    = '关闭日期';
$lang->sprint->canceledBy    = '由谁取消';
$lang->sprint->canceledDate  = '取消日期';
$lang->sprint->owner         = '负责人';
$lang->sprint->PO            = $lang->productCommon . '负责人';
$lang->sprint->PM            = $lang->sprintcommon . '负责人';
$lang->sprint->QD            = '测试负责人';
$lang->sprint->RD            = '发布负责人';
$lang->sprint->acl           = '访问控制';
$lang->sprint->teamname      = '团队名称';
$lang->sprint->order         = $lang->sprintcommon . '排序';
$lang->sprint->products      = '相关' . $lang->productCommon;
$lang->sprint->childsprints = "子{$lang->sprintcommon}";
$lang->sprint->whitelist     = '分组白名单';
$lang->sprint->totalEstimate = '总预计';
$lang->sprint->totalConsumed = '总消耗';
$lang->sprint->totalLeft     = '总剩余';
$lang->sprint->Left          = '剩余';
$lang->sprint->progess       = '进度';
$lang->sprint->viewBug       = '查看bug';
$lang->sprint->noProduct     = "无{$lang->productCommon}{$lang->sprintcommon}";
$lang->sprint->select        = "--请选择{$lang->sprintcommon}--";
$lang->sprint->createStory   = "新增需求";
$lang->sprint->all           = '所有';
$lang->sprint->undone        = '未完成';
$lang->sprint->unclosed      = '未关闭';
$lang->sprint->typeDesc      = "运维{$lang->sprintcommon}禁用燃尽图和需求。";
$lang->sprint->mine          = '我负责：';
$lang->sprint->other         = '其他：';
$lang->sprint->deleted       = '已删除';

$lang->sprint->start    = '开始';
$lang->sprint->activate = '激活';
$lang->sprint->putoff   = '延期';
$lang->sprint->suspend  = '挂起';
$lang->sprint->close    = '结束';

$lang->sprint->typeList['sprint']    = "短期$lang->sprintcommon";
$lang->sprint->typeList['waterfall'] = "长期$lang->sprintcommon";
$lang->sprint->typeList['ops']       = "运维$lang->sprintcommon";

$lang->sprint->endList[7]    = '一星期';
$lang->sprint->endList[14]   = '两星期';
$lang->sprint->endList[31]   = '一个月';
$lang->sprint->endList[62]   = '两个月';
$lang->sprint->endList[93]   = '三个月';
$lang->sprint->endList[186]  = '半年';
$lang->sprint->endList[365]  = '一年';

$lang->team = new stdclass();
$lang->team->account    = '用户';
$lang->team->role       = '角色';
$lang->team->join       = '加盟日';
$lang->team->hours      = '可用工时/天';
$lang->team->days       = '可用工日';
$lang->team->totalHours = '总计';
 
$lang->sprint->basicInfo = '基本信息';
$lang->sprint->otherInfo = '其他信息';

/* 字段取值列表。*/
$lang->sprint->statusList['wait']      = '未开始';
$lang->sprint->statusList['doing']     = '进行中';
$lang->sprint->statusList['suspended'] = '已挂起';
$lang->sprint->statusList['done']      = '已完成';

$lang->sprint->aclList['open']    = "默认设置(有{$lang->sprintcommon}视图权限，即可访问)";
$lang->sprint->aclList['private'] = "私有{$lang->sprintcommon}(只有{$lang->sprintcommon}团队成员才能访问)";
$lang->sprint->aclList['custom']  = "自定义白名单(团队成员和白名单的成员可以访问)";

/* 方法列表。*/
$lang->sprint->index            = "{$lang->sprintcommon}首页";
$lang->sprint->task             = '任务列表';
$lang->sprint->groupTask        = '分组浏览任务';
$lang->sprint->story            = 'Story列表';
$lang->sprint->bug              = 'Bug列表';
$lang->sprint->dynamic          = '动态';
$lang->sprint->build            = '版本列表';
$lang->sprint->testtask         = '测试任务';
$lang->sprint->burn             = '燃尽图';
$lang->sprint->baseline         = '基准线';
$lang->sprint->computeBurn      = '更新';
$lang->sprint->burnData         = '燃尽图数据';
$lang->sprint->team             = '团队成员';
$lang->sprint->doc              = '文档列表';
$lang->sprint->manageProducts   = '关联' . $lang->productCommon;
$lang->sprint->linkStory        = '关联需求';
$lang->sprint->view             = "{$lang->sprintcommon}概况";
$lang->sprint->create           = "添加{$lang->sprintcommon}";
$lang->sprint->copy             = "复制{$lang->sprintcommon}";
$lang->sprint->delete           = "删除{$lang->sprintcommon}";
$lang->sprint->browse           = "浏览{$lang->sprintcommon}";
$lang->sprint->edit             = "编辑{$lang->sprintcommon}";
$lang->sprint->batchEdit        = "批量编辑";
$lang->sprint->manageMembers    = '团队管理';
$lang->sprint->unlinkMember     = '移除成员';
$lang->sprint->unlinkStory      = '移除需求';
$lang->sprint->batchUnlinkStory = '批量移除需求';
$lang->sprint->importTask       = '转入任务';
$lang->sprint->importBug        = '导入Bug';
$lang->sprint->ajaxGetProducts  = "接口：获得{$lang->sprintcommon}{$lang->productCommon}列表";
$lang->sprint->updateOrder      = '排序';

/* 分组浏览。*/
$lang->sprint->allTasks             = '所有';
$lang->sprint->assignedToMe         = '指派给我';

$lang->sprint->statusSelects['']             = '更多';
$lang->sprint->statusSelects['finishedbyme'] = '我完成';
$lang->sprint->statusSelects['wait']         = '未开始';
$lang->sprint->statusSelects['doing']        = '进行中';
$lang->sprint->statusSelects['undone']       = '未完成';
$lang->sprint->statusSelects['done']         = '已完成';
$lang->sprint->statusSelects['closed']       = '已关闭';
$lang->sprint->statusSelects['delayed']      = '已延期';
$lang->sprint->statusSelects['needconfirm']  = '需求变动';
$lang->sprint->statusSelects['cancel']       = '已取消';
$lang->sprint->groups['']           = '分组查看';
$lang->sprint->groups['story']      = '需求分组';
$lang->sprint->groups['status']     = '状态分组';
$lang->sprint->groups['pri']        = '优先级分组';
$lang->sprint->groups['openedby']   = '创建者分组';
$lang->sprint->groups['assignedTo'] = '指派给分组';
$lang->sprint->groups['finishedby'] = '完成者分组';
$lang->sprint->groups['closedby']   = '关闭者分组';
$lang->sprint->groups['estimate']   = '预计分组';
$lang->sprint->groups['consumed']   = '已消耗分组';
$lang->sprint->groups['left']       = '剩余分组';
$lang->sprint->groups['type']       = '类型分组';
$lang->sprint->groups['deadline']   = '截止分组';

$lang->sprint->moduleTask           = '按模块';
$lang->sprint->byQuery              = '搜索';

/* 查询条件列表。*/
$lang->sprint->allsprint      = "所有{$lang->sprintcommon}";
$lang->sprint->aboveAllProduct = "以上所有{$lang->productCommon}";
$lang->sprint->aboveAllsprint = "以上所有{$lang->sprintcommon}";

/* 页面提示。*/
$lang->sprint->selectsprint   = "请选择{$lang->sprintcommon}";
$lang->sprint->beginAndEnd     = '起止时间';
$lang->sprint->lblStats        = '工时统计';
$lang->sprint->stats           = '可用工时<strong>%s</strong>工时<br />总共预计<strong>%s</strong>工时<br />已经消耗<strong>%s</strong>工时<br />预计剩余<strong>%s</strong>工时';
$lang->sprint->oneLineStats    = "{$lang->sprintcommon}<strong>%s</strong>, 代号为<strong>%s</strong>, 相关{$lang->productCommon}为<strong>%s</strong>，<strong>%s</strong>开始，<strong>%s</strong>结束，总预计<strong>%s</strong>工时，已消耗<strong>%s</strong>工时，预计剩余<strong>%s</strong>工时。";
$lang->sprint->taskSummary     = "本页共 <strong>%s</strong> 个任务，未开始<strong>%s</strong>，进行中<strong>%s</strong>，总预计<strong>%s</strong>工时，已消耗<strong>%s</strong>工时，剩余<strong>%s</strong>工时。";
$lang->sprint->memberHours     = "%s共有 <strong>%s</strong> 个可用工时，";
$lang->sprint->groupSummary    = "本组共 <strong>%s</strong> 个任务，未开始<strong>%s</strong>，进行中<strong>%s</strong>，总预计<strong>%s</strong>工时，已消耗<strong>%s</strong>工时，剩余<strong>%s</strong>工时。";
$lang->sprint->wbs             = "分解任务";
$lang->sprint->batchWBS        = "批量分解";
$lang->sprint->largeBurnChart  = '点击查看大图';
$lang->sprint->howToUpdateBurn = "<a href='http://api.zentao.net/goto.php?item=burndown&lang=zh-cn' target='_blank' title='如何更新燃尽图？'><i class='icon-question-sign'></i></a>";
$lang->sprint->whyNoStories    = "看起来没有需求可以关联。请检查下{$lang->sprintcommon}关联的{$lang->productCommon}中有没有需求，而且要确保它们已经审核通过。";
$lang->sprint->donesprints    = '已结束';
$lang->sprint->unDonesprints  = '未结束';
$lang->sprint->copyTeam        = '复制团队';
$lang->sprint->copyFromTeam    = "复制自{$lang->sprintcommon}团队： <strong>%s</strong>";
$lang->sprint->noMatched       = "找不到包含'%s'的$lang->sprintcommon";
$lang->sprint->copyTitle       = "请选择一个{$lang->sprintcommon}来复制";
$lang->sprint->copyTeamTitle   = "请选择一个{$lang->sprintcommon}团队来复制";
$lang->sprint->copyNosprint   = "没有可用的{$lang->sprintcommon}来复制";
$lang->sprint->copyFromsprint = "复制自{$lang->sprintcommon} <strong>%s</strong>";
$lang->sprint->reCopy          = '重新复制';
$lang->sprint->cancelCopy      = '取消复制';
$lang->sprint->byPeriod        = '按时间段';
$lang->sprint->byUser          = '按用户';

/* 交互提示。*/
$lang->sprint->confirmDelete         = "您确定删除{$lang->sprintcommon}[%s]吗？";
$lang->sprint->confirmUnlinkMember   = "您确定从该{$lang->sprintcommon}中移除该用户吗？";
$lang->sprint->confirmUnlinkStory    = "您确定从该{$lang->sprintcommon}中移除该需求吗？";
$lang->sprint->errorNoLinkedProducts = "该{$lang->sprintcommon}没有关联的{$lang->productCommon}，系统将转到{$lang->productCommon}关联页面";
$lang->sprint->accessDenied          = "您无权访问该{$lang->sprintcommon}！";
$lang->sprint->tips                  = '提示';
$lang->sprint->afterInfo             = "{$lang->sprintcommon}添加成功，您现在可以进行以下操作：";
$lang->sprint->setTeam               = '设置团队';
$lang->sprint->linkStory             = '关联需求';
$lang->sprint->createTask            = '添加任务';
$lang->sprint->goback                = "返回{$lang->sprintcommon}首页";
$lang->sprint->linkProduct           = "选择{$lang->productCommon}关联...";
$lang->sprint->noweekend             = '去除周末';
$lang->sprint->withweekend           = '显示周末';
$lang->sprint->interval              = '间隔';

/* 统计。*/
$lang->sprint->charts = new stdclass();
$lang->sprint->charts->burn = new stdclass();
$lang->sprint->charts->burn->graph = new stdclass();
$lang->sprint->charts->burn->graph->caption      = "燃尽图";
$lang->sprint->charts->burn->graph->xAxisName    = "日期";
$lang->sprint->charts->burn->graph->yAxisName    = "HOUR";
$lang->sprint->charts->burn->graph->baseFontSize = 12;
$lang->sprint->charts->burn->graph->formatNumber = 0;
$lang->sprint->charts->burn->graph->animation    = 0;
$lang->sprint->charts->burn->graph->rotateNames  = 1;
$lang->sprint->charts->burn->graph->showValues   = 0;

$lang->sprint->placeholder = new stdclass();
$lang->sprint->placeholder->code = '团队内部的简称';

$lang->sprint->selectGroup = new stdclass();
$lang->sprint->selectGroup->doing     = '(进行中)';
$lang->sprint->selectGroup->suspended = '(已挂起)';
$lang->sprint->selectGroup->done      = '(已结束)';

$lang->sprint->sprintTasks = $lang->sprintcommon;

$lang->sprint->confirmChangeProject  = "修改{$lang->projectCommon}会导致相应的所属模块、相关需求和指派人发生变化，确定吗？";

$lang->sprint->taskhour     =  '点数';
$lang->sprint->legendEffort = '点数信息';
$lang->sprint->project      =  '所属项目';
$lang->sprint->planRange = '计划周期';
$lang->sprint->realRange = '实际周期';
$lang->sprint->goal ='目标';
$lang->sprint->stroyPoint ='故事点相关';
$lang->sprint->estimatePoints = '预估点数';
$lang->sprint->realPoints ='实际点数';
$lang->sprint->explain = '调整说明';
$lang->sprint->referenceStory = '基准故事';
$lang->sprint->conference ='会议内容';
$lang->sprint->time = '时间';
$lang->sprint->place = '地点';
$lang->sprint->person ='与会人员';
$lang->sprint->completeFuncReview ='完成功能演示';
$lang->sprint->summary ='总结内容';
$lang->sprint->steps = "<p >值得保持的地方:</p><p >值得改进的地方:</p>";
$lang->sprint->review ='回顾会';
$lang->sprint->storyview ='storyview';
$lang->sprint->taskcreate ='分解任务';
$lang->sprint->taskbatchCreate  = '批量添加任务';
$lang->sprint->taskview = 'taskview';
$lang->sprint->edit = '编辑sprint';
$lang->sprint->bugview = 'sprint-bugview';
$lang->sprint->bugedit = '编辑bug';
$lang->sprint->reviewedit = '编辑回顾会';
$lang->sprint->reviewdelete = ' 删除回顾会';
$lang->sprint->createreview = ' 创建回顾会';
$lang->sprint->product ='所属产品';
$lang->sprint->totalMemebers = '团队人数';
$lang->sprint->teamMembers = '团队成员';
$lang->sprint->managemembers ='团队管理';
$lang->sprint->changestory   ='变更Story';
$lang->sprint->storyedit     ='编辑Story';
$lang->sprint->storyreview   ='评审Story';
$lang->sprint->open          ='重新打开bug';
$lang->sprint->importbugs    = '导入Bug';
$lang->sprint->downloadExcel = '下载Excel模板';
$lang->sprint->delayWarn     = '截止时间已过，系统已自动将本Sprint截止日期延长到今天！';

$lang->review             = new stdclass();
$lang->review->legendBasicInfo = '回顾会信息';
$lang->review->sprintInfo = '迭代信息';

$lang->Bug                = new stdclass();
$lang->Bug->assignedToMe  = '指派给我';
$lang->Bug->all           = '所有Bug';