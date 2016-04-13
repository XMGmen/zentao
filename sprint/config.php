<?php
$config->sprint          = new stdclass();
$config->sprint->orderBy = 'isDone,status,order_desc';

$config->sprint->editor               = new stdclass();
$config->sprint->editor->review       = array('id' => 'content,referenceStory,completeFunc,summary,other', 'tools' => 'simpleTools');
$config->sprint->editor->createreview = array('id' => 'content,referenceStory,completeFunc,summary,other', 'tools' => 'simpleTools');
$config->sprint->editor->reviewedit   = array('id' => 'content,referenceStory,completeFunc,summary,other', 'tools' => 'simpleTools');
$config->sprint->editor->bugedit      = array('id' => 'steps', 'tools' => 'simpleTools');
