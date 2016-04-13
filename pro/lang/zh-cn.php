<?php
/**
 * The product module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: zh-cn.php 5091 2013-07-10 06:06:46Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->product->common      = $lang->productCommon . '视图';
$lang->product->index       = $lang->productCommon . "首页";
$lang->product->browse      = "浏览{$lang->productCommon}";
$lang->product->dynamic     = "动态";
$lang->product->view        = "{$lang->productCommon}概况";
$lang->product->edit        = "编辑{$lang->productCommon}";
$lang->product->batchEdit   = "批量编辑";
$lang->product->create      = "新增{$lang->productCommon}";
$lang->product->read        = "{$lang->productCommon}详情";
$lang->product->delete      = "删除{$lang->productCommon}";
$lang->product->deleted     = "已删除";
$lang->product->close       = "关闭";
$lang->product->select      = "--请选择{$lang->productCommon}--";
$lang->product->mine        = '我负责：';
$lang->product->other       = '其他：';
$lang->product->closed      = '已关闭';
$lang->product->updateOrder = "排序";

$lang->product->basicInfo = '基本信息';
$lang->product->otherInfo = '其他信息';

$lang->product->plans    = '计划数';
$lang->product->releases = '发布数';
$lang->product->docs     = '文档数';
$lang->product->bugs     = '相关BUG';
$lang->product->projects = "关联{$lang->projectCommon}数";
$lang->product->cases    = '用例数';
$lang->product->builds   = 'BUILD数';
$lang->product->roadmap  = '路线图';
$lang->product->doc      = '文档列表';
$lang->product->project  = $lang->projectCommon . '列表';

$lang->product->selectProduct   = "请选择{$lang->productCommon}";
$lang->product->saveButton      = " 保存 (S) ";
$lang->product->confirmDelete   = " 您确定删除该{$lang->productCommon}吗？";
$lang->product->ajaxGetProjects = "接口:{$lang->projectCommon}列表";
$lang->product->ajaxGetPlans    = "接口:计划列表";

$lang->product->errorFormat    = "{$lang->productCommon}数据格式不正确";
$lang->product->errorEmptyName = "{$lang->productCommon}名称不能为空";
$lang->product->errorEmptyCode = "{$lang->productCommon}代号不能为空";
$lang->product->errorNoProduct = "还没有创建{$lang->productCommon}！";
$lang->product->accessDenied   = "您无权访问该{$lang->productCommon}";

$lang->product->id        = '编号';
$lang->product->company   = '所属公司';
$lang->product->name      = "{$lang->productCommon}名称";
$lang->product->code      = "{$lang->productCommon}代号";
$lang->product->order     = '排序';
$lang->product->status    = '状态';
$lang->product->desc      = "{$lang->productCommon}描述";
$lang->product->PO        = "{$lang->productCommon}负责人";
$lang->product->QD        = '测试负责人';
$lang->product->RD        = '发布负责人';
$lang->product->acl       = '访问控制';
$lang->product->whitelist = '分组白名单';

$lang->product->moduleStory  = '按模块';
$lang->product->searchStory  = '搜索';
$lang->product->assignedToMe = '指派给我';
$lang->product->openedByMe   = '由我创建';
$lang->product->reviewedByMe = '由我评审';
$lang->product->closedByMe   = '由我关闭';
$lang->product->draftStory   = '草稿';
$lang->product->activeStory  = '激活';
$lang->product->changedStory = '已变更';
$lang->product->willClose    = '待关闭';
$lang->product->closedStory  = '已关闭';
$lang->product->unclosed     = '未关闭';

$lang->product->allStory    = '全部需求';
$lang->product->allProduct  = '全部' . $lang->productCommon;
$lang->product->allProductsOfProject = '全部关联' . $lang->productCommon;

$lang->product->statusList['']       = '';
$lang->product->statusList['normal'] = '正常';
$lang->product->statusList['closed'] = '结束';

$lang->product->aclList['open']    = "默认设置(有{$lang->productCommon}视图权限，即可访问)";
$lang->product->aclList['private'] = "私有{$lang->productCommon}(只有{$lang->projectCommon}团队成员才能访问)";
$lang->product->aclList['custom']  = '自定义白名单(团队成员和白名单的成员可以访问)';

$lang->product->storySummary = "本页共 <strong>%s</strong> 个需求，预计 <strong>%s</strong> 个工时，用例覆盖率<strong>%s</strong>。";
$lang->product->noMatched    = '找不到包含"%s"的' . $lang->productCommon;

$lang->story->browse      = "需求列表";
$lang->story->create      = "提需求";
$lang->story->createCase  = "建用例";
$lang->story->batchCreate = "批量添加";
$lang->story->changeBacklog     = "变更Backlog";
$lang->story->changed     = '需求变更';
$lang->story->review      = '评审';
$lang->story->batchReview = '批量评审';
$lang->story->editBacklog        = "编辑Backlog";
$lang->story->batchEdit   = "批量编辑";
$lang->story->close       = '关闭';
$lang->story->batchClose  = '批量关闭';
$lang->story->activate    = '激活';
$lang->story->delete      = "删除";
$lang->story->view        = "需求详情";
$lang->story->legend      = "相关";
$lang->story->tasks       = "相关任务";
$lang->story->taskCount   = '任务数';
$lang->story->bugs        = "Bug";
$lang->story->linkStory   = '关联需求';
$lang->story->export      = "导出数据";
$lang->story->zeroCase    = "零用例需求";
$lang->story->reportChart = "统计报表";
$lang->story->batchChangePlan  = "批量修改计划";
$lang->story->batchChangeStage = "批量修改阶段";
$lang->story->batchAssignTo    = "批量指派";

$lang->story->common         = '需求';
$lang->story->id             = '编号';
$lang->story->product        = "所属{$lang->productCommon}";
$lang->story->module         = '所属模块';
$lang->story->source         = '来源';
$lang->story->fromBug        = '来源Bug';
$lang->story->release        = '发布计划';
$lang->story->bug            = '相关bug';
$lang->story->title          = '需求名称';
$lang->story->spec           = '需求描述';
$lang->story->verify         = '验收标准';
$lang->story->type           = '需求类型 ';
$lang->story->pri            = '优先级';
$lang->story->estimate       = '预计工时';
$lang->story->estimateAB     = '预计';
$lang->story->hour           = '小时';
$lang->story->status         = '当前状态';
$lang->story->stage          = '所处阶段';
$lang->story->stageAB        = '阶段';
$lang->story->mailto         = '抄送给';
$lang->story->openedBy       = '由谁创建';
$lang->story->openedDate     = '创建日期';
$lang->story->assignedTo     = '指派给';
$lang->story->assignedDate   = '指派日期';
$lang->story->lastEditedBy   = '最后修改';
$lang->story->lastEditedDate = '最后修改日期';
$lang->story->lastEdited     = '最后修改';
$lang->story->closedBy       = '由谁关闭';
$lang->story->closedDate     = '关闭日期';
$lang->story->closedReason   = '关闭原因';
$lang->story->rejectedReason = '拒绝原因';
$lang->story->reviewedBy     = '由谁评审';
$lang->story->reviewedDate   = '评审时间';
$lang->story->version        = '版本号';
$lang->story->project        = '所属' . $lang->projectCommon;
$lang->story->plan           = '所属计划';
$lang->story->planAB         = '计划';
$lang->story->comment        = '备注';
$lang->story->linkStories    = '相关需求';
$lang->story->childStories   = '细分需求';
$lang->story->duplicateStory = '重复需求';
$lang->story->reviewResult   = '评审结果';
$lang->story->preVersion     = '之前版本';
$lang->story->keywords       = '关键词';
$lang->story->newStory       = '继续添加需求';

$lang->story->same = '同上';

$lang->story->useList[0] = '不使用';
$lang->story->useList[1] = '使用';

$lang->story->statusList['']          = '';
$lang->story->statusList['draft']     = '草稿';
$lang->story->statusList['active']    = '激活';
$lang->story->statusList['closed']    = '已关闭';
$lang->story->statusList['changed']   = '已变更';

$lang->story->stageList['']           = '';
$lang->story->stageList['wait']       = '未开始';
$lang->story->stageList['planned']    = '已计划';
$lang->story->stageList['projected']  = '已立项';
$lang->story->stageList['developing'] = '研发中';
$lang->story->stageList['developed']  = '研发完毕';
$lang->story->stageList['testing']    = '测试中';
$lang->story->stageList['tested']     = '测试完毕';
$lang->story->stageList['verified']   = '已验收';
$lang->story->stageList['released']   = '已发布';
$lang->story->stageList['canceled']   = '已取消';

$lang->story->reasonList['']           = '';
$lang->story->reasonList['done']       = '已完成';
$lang->story->reasonList['subdivided'] = '已细分';
$lang->story->reasonList['duplicate']  = '重复';
$lang->story->reasonList['postponed']  = '延期';
$lang->story->reasonList['willnotdo']  = '不做';
$lang->story->reasonList['cancel']     = '已取消';
$lang->story->reasonList['bydesign']   = '设计如此';
//$lang->story->reasonList['isbug']      = '是个Bug';

$lang->story->reviewResultList['']        = '';
$lang->story->reviewResultList['pass']    = '确认通过';
$lang->story->reviewResultList['revert']  = '撤销变更';
$lang->story->reviewResultList['clarify'] = '有待明确';
$lang->story->reviewResultList['reject']  = '拒绝';

$lang->story->reviewList[0] = '否';
$lang->story->reviewList[1] = '是';

$lang->story->sourceList['']           = '';
$lang->story->sourceList['customer']   = '客户';
$lang->story->sourceList['user']       = '用户';
$lang->story->sourceList['po']         = $lang->productCommon . '经理';
$lang->story->sourceList['market']     = '市场';
$lang->story->sourceList['service']    = '客服';
$lang->story->sourceList['competitor'] = '竞争对手';
$lang->story->sourceList['partner']    = '合作伙伴';
$lang->story->sourceList['dev']        = '开发人员';
$lang->story->sourceList['tester']     = '测试人员';
$lang->story->sourceList['bug']        = 'Bug';
$lang->story->sourceList['other']      = '其他';

$lang->story->priList[]   = '';
$lang->story->priList[3]  = '3';
$lang->story->priList[1]  = '1';
$lang->story->priList[2]  = '2';
$lang->story->priList[4]  = '4';

$lang->story->legendBasicInfo      = '基本信息';
$lang->story->legendLifeTime       = '需求的一生';
$lang->story->legendRelated        = '相关信息';
$lang->story->legendMailto         = '抄送给';
$lang->story->legendAttatch        = '附件';
$lang->story->legendProjectAndTask = $lang->projectCommon . '任务';
$lang->story->legendBugs           = '相关Bug';
$lang->story->legendFromBug        = '来源Bug';
$lang->story->legendCases          = '相关用例';
$lang->story->legendLinkStories    = '相关需求';
$lang->story->legendChildStories   = '细分需求';
$lang->story->legendSpec           = '需求描述';
$lang->story->legendVerify         = '验收标准';
$lang->story->legendHistory        = '历史记录';
$lang->story->legendMisc           = '其他相关';

$lang->story->lblChange            = '变更需求';
$lang->story->lblReview            = '评审需求';
$lang->story->lblActivate          = '激活需求';
$lang->story->lblClose             = '关闭需求';

$lang->story->checkAffection       = '检查影响';
$lang->story->affectedProjects     = '影响的' . $lang->projectCommon;
$lang->story->affectedBugs         = '影响的Bug';
$lang->story->affectedCases        = '影响的用例';

$lang->story->specTemplate          = "建议参考的模板：作为一名<<i class='text-important'>某种类型的用户</i>>，我希望<<i class='text-important'>达成某些目的</i>>，这样可以<<i class='text-important'>开发的价值</i>>。";
$lang->story->needNotReview         = '不需要评审';
$lang->story->afterSubmit           = "添加之后";
$lang->story->successSaved          = "需求成功添加，";
$lang->story->confirmDelete         = "您确认删除该需求吗?";
$lang->story->confirmBatchClose     = "您确认关闭这些需求吗?";
$lang->story->errorFormat           = '需求数据有误';
$lang->story->errorEmptyTitle       = '标题不能为空';
$lang->story->mustChooseResult      = '必须选择评审结果';
$lang->story->mustChoosePreVersion  = '必须选择回溯的版本';
$lang->story->ajaxGetProjectStories = "接口:获取{$lang->projectCommon}需求列表";
$lang->story->ajaxGetProductStories = "接口:获取{$lang->productCommon}需求列表";

$lang->story->form = new stdclass();
$lang->story->form->titleNote = '一句话简要表达需求内容';
$lang->story->form->area      = '该需求所属范围';
$lang->story->form->desc      = '描述及标准，什么需求？如何验收？';
$lang->story->form->resource  = '资源分配，有谁完成？需要多少时间？';
$lang->story->form->file      = '附件，如果该需求有相关文件，请点此上传。';

$lang->story->action = new stdclass();
$lang->story->action->reviewed            = array('main' => '$date, 由 <strong>$actor</strong> 记录评审结果，结果为 <strong>$extra</strong>。', 'extra' => $lang->story->reviewResultList);
$lang->story->action->closed              = array('main' => '$date, 由 <strong>$actor</strong> 关闭，原因为 <strong>$extra</strong>。', 'extra' => $lang->story->reasonList);
$lang->story->action->linked2plan         = array('main' => '$date, 由 <strong>$actor</strong> 关联到计划 <strong>$extra</strong>。');
$lang->story->action->unlinkedfromplan    = array('main' => '$date, 由 <strong>$actor</strong> 从计划 <strong>$extra</strong> 移除。');
$lang->story->action->linked2project      = array('main' => '$date, 由 <strong>$actor</strong> 关联到' . $lang->projectCommon . ' <strong>$extra</strong>。');
$lang->story->action->unlinkedfromproject = array('main' => '$date, 由 <strong>$actor</strong> 从' . $lang->projectCommon . ' <strong>$extra</strong> 移除。');

/* 统计报表。*/
$lang->story->report = new stdclass();
$lang->story->report->common = '报表';
$lang->story->report->select = '请选择报表类型';
$lang->story->report->create = '生成报表';
$lang->story->report->value  = '需求数';

$lang->story->report->charts['storysPerProduct']        = $lang->productCommon . '需求数量';
$lang->story->report->charts['storysPerModule']         = '模块需求数量';
$lang->story->report->charts['storysPerSource']         = '需求来源统计';
$lang->story->report->charts['storysPerPlan']           = '计划进行统计';
$lang->story->report->charts['storysPerStatus']         = '状态进行统计';
$lang->story->report->charts['storysPerStage']          = '所处阶段进行统计';
$lang->story->report->charts['storysPerPri']            = '优先级进行统计';
$lang->story->report->charts['storysPerEstimate']       = '预计工时进行统计';
$lang->story->report->charts['storysPerOpenedBy']       = '由谁创建来进行统计';
$lang->story->report->charts['storysPerAssignedTo']     = '当前指派来进行统计';
$lang->story->report->charts['storysPerClosedReason']   = '关闭原因来进行统计';
$lang->story->report->charts['storysPerChange']         = '变更次数来进行统计';

$lang->story->report->options = new stdclass();
$lang->story->report->options->graph   = new stdclass();
$lang->story->report->options->type    = 'pie';
$lang->story->report->options->width   = 500;
$lang->story->report->options->height  = 140;

$lang->story->report->storysPerProduct      = new stdclass();
$lang->story->report->storysPerModule       = new stdclass();
$lang->story->report->storysPerSource       = new stdclass();
$lang->story->report->storysPerPlan         = new stdclass();
$lang->story->report->storysPerStatus       = new stdclass();
$lang->story->report->storysPerStage        = new stdclass();
$lang->story->report->storysPerPri          = new stdclass();
$lang->story->report->storysPerOpenedBy     = new stdclass();
$lang->story->report->storysPerAssignedTo   = new stdclass();
$lang->story->report->storysPerClosedReason = new stdclass();
$lang->story->report->storysPerEstimate     = new stdclass();
$lang->story->report->storysPerChange       = new stdclass();

$lang->story->report->storysPerProduct->item      = $lang->productCommon;
$lang->story->report->storysPerModule->item       = '模块';
$lang->story->report->storysPerSource->item       = '来源';
$lang->story->report->storysPerPlan->item         = '计划';
$lang->story->report->storysPerStatus->item       = '状态';
$lang->story->report->storysPerStage->item        = '阶段';
$lang->story->report->storysPerPri->item          = '优先级';
$lang->story->report->storysPerOpenedBy->item     = '用户';
$lang->story->report->storysPerAssignedTo->item   = '用户';
$lang->story->report->storysPerClosedReason->item = '原因';
$lang->story->report->storysPerEstimate->item     = '预计工时';
$lang->story->report->storysPerChange->item       = '变更次数';

$lang->story->report->storysPerProduct->graph      = new stdclass();
$lang->story->report->storysPerModule->graph       = new stdclass();
$lang->story->report->storysPerSource->graph       = new stdclass();
$lang->story->report->storysPerPlan->graph         = new stdclass();
$lang->story->report->storysPerStatus->graph       = new stdclass();
$lang->story->report->storysPerStage->graph        = new stdclass();
$lang->story->report->storysPerPri->graph          = new stdclass();
$lang->story->report->storysPerOpenedBy->graph     = new stdclass();
$lang->story->report->storysPerAssignedTo->graph   = new stdclass();
$lang->story->report->storysPerClosedReason->graph = new stdclass();
$lang->story->report->storysPerEstimate->graph     = new stdclass();
$lang->story->report->storysPerChange->graph       = new stdclass();

$lang->story->report->storysPerProduct->graph->xAxisName      = $lang->productCommon;
$lang->story->report->storysPerModule->graph->xAxisName       = '模块';
$lang->story->report->storysPerSource->graph->xAxisName       = '来源';
$lang->story->report->storysPerPlan->graph->xAxisName         = '计划';
$lang->story->report->storysPerStatus->graph->xAxisName       = '状态';
$lang->story->report->storysPerStage->graph->xAxisName        = '所处阶段';
$lang->story->report->storysPerPri->graph->xAxisName          = '优先级';
$lang->story->report->storysPerOpenedBy->graph->xAxisName     = '由谁创建';
$lang->story->report->storysPerAssignedTo->graph->xAxisName   = '当前指派';
$lang->story->report->storysPerClosedReason->graph->xAxisName = '关闭原因';
$lang->story->report->storysPerEstimate->graph->xAxisName     = '预计时间';
$lang->story->report->storysPerChange->graph->xAxisName       = '变更次数';

$lang->story->placeholder = new stdclass();
$lang->story->placeholder->estimate = "完成该需求的工作量";

$lang->story->chosen = new stdClass();
$lang->story->chosen->reviewedBy = '选择评审人...';

//addedbyheng
$lang->sprint->name = 'Sprint名称';
$lang->sprint->code = 'Sprint代号';
$lang->sprint->end  = '结束日期';
$lang->sprint->status = '状态';
$lang->sprint->totalEstimate = '总预计';
$lang->sprint->totalConsumed = '总消耗';
$lang->sprint->totalLeft = '总剩余';
$lang->sprint->progess = '进度';
$lang->sprint->burn = '燃尽图';
$lang->sprint->weather = 'Weather';
$lang->sprint->sprintname = 'Sprint';
$lang->sprint->bugname = 'Bug';
$lang->sprint->backlogname = '项目Back Log';
$lang->sprint->begin = '开始日期';

$lang->bug->editbug ='编辑BUG';
$lang->my->home->createProject = "创建Sprint";
$lang->sprint->create  = '添加Sprint';
$lang->sprint->type    =  'Sprint类型';
$lang->sprint->desc    =  'Sprint目标';
$lang->sprint->managePlans =  '关联项目';
$lang->sprint->linkPlan    =  '请选择关联项目';

//addedbyheng
$lang->pro->project    = '所属项目';
$lang->pro->estimate   = '预计点数';
$lang->pro->sprint     = '所属Sprint';
$lang->pro->sprintin       = '参与Sprint';
$lang->pro->teamMembers    = '团队成员';
$lang->pro->totalMemebers  = '团队人数';

// addedbyclj
$lang->pro->common     = 'Plan视图'; //++ 
$lang->pro->index      = 'Sprint列表'; 
$lang->pro->backlog    = '项目Back Log'; 
$lang->pro->bug        = '项目Bug'; 
$lang->pro->team       = '团队视图'; 
$lang->pro->unlinkMember  ='删除团队成员';//++
$lang->pro->sprintedit    = '编辑Sprint';//++
$lang->pro->delete        = '删除Sprint';
$lang->pro->sprintcreate  = '创建Sprint';
$lang->pro->backloglist   = 'Backlog列表';
$lang->pro->backlogview   = 'Backlog视图';
$lang->pro->backlogchange = 'Backlog变更';
$lang->pro->backlogedit   = '编辑Backlog';
$lang->pro->bugview       = '项目Bug视图';
$lang->pro->bugedit       = '编辑Bug';
$lang->pro->managemembers = '团队管理';
$lang->pro->importbugs    = '导入Bug';
$lang->pro->downloadExcel = '下载Excel模板';
$lang->Backlog->legendBasicInfo = '基本信息';
$lang->pro->backlogreview = 'Backlog评审';
$lang->pro->teamManage    = '团队管理';
