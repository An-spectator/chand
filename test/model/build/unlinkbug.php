#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/build.class.php';
su('admin');

/**

title=测试 buildModel->unlinkBug();
cid=1
pid=1

*/

$build = new buildTest();

r($build->unlinkBugTest()) && p() && e();