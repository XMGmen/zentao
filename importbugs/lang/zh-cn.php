<?php
$lang->importbugs = new stdclass();
$lang->importbugs->common  = '导入Bug';
$lang->importbugs->success = '导入成功';
$lang->importbugs->fail    = '导入失败';
$lang->importbugs->upload  = '导入Bug';

$lang->importbugs->stageMap[] = '';
$lang->importbugs->stageMap['文档检查'] = 'docTest';
$lang->importbugs->stageMap['SIT测试']  = 'SITtest';
$lang->importbugs->stageMap['UAT测试']  = 'UATtest';
$lang->importbugs->stageMap['内测阶段'] = 'inStage';
$lang->importbugs->stageMap['生产问题'] = 'proStage';
$lang->importbugs->stageMap['代码检查'] = 'codeReview';

$lang->importbugs->typeMap[] = '';
$lang->importbugs->typeMap['功能问题']      = 'function';
$lang->importbugs->typeMap['数据问题']      = 'data';
$lang->importbugs->typeMap['用户界面问题']  = 'userview';
$lang->importbugs->typeMap['设计问题']      = 'design';
$lang->importbugs->typeMap['性能问题']      = 'performance';
$lang->importbugs->typeMap['环境/配置问题'] = 'config';
$lang->importbugs->typeMap['兼容问题']     = 'compatible';
$lang->importbugs->typeMap['性能问题']     = 'performance';
$lang->importbugs->typeMap['业务改进']     = 'improvement';
$lang->importbugs->typeMap['易用性问题']   = 'friendly';
$lang->importbugs->typeMap['安全性问题']   = 'security';
$lang->importbugs->typeMap['RV-接口问题']  = 'RVinterface';
$lang->importbugs->typeMap['RV-代码逻辑问题'] = 'RVlogistic';
$lang->importbugs->typeMap['RV-接口问题']  = 'RVinterface';
$lang->importbugs->typeMap['RV-代码规范']  = 'RVformulation';
$lang->importbugs->typeMap['RV-重复代码']  = 'RVrepeat';
$lang->importbugs->typeMap['RV-参数校验']  = 'RVparameter';
$lang->importbugs->typeMap['RV-数据重构']  = 'RVconstruct';