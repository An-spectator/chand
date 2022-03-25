#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/productplan.class.php';

$plan = new productPlan('admin');

$planId = array();
$planId[0] = 5;
$planId[1] = 'doing';
$planId[2] = 'done';
$planId[3] = 'closed';
$planId[4] = 'started';
$planId[5] = 'finished';
$planId[6] = 'closed';
$planId[7] = 'activated';

r($plan->updateStatus($planId[0], $planId[1], $planId[4])) && p() && e('1'); //修改id=5的状态为doing
r($plan->updateStatus($planId[0], $planId[2], $planId[5])) && p() && e('1'); //修改状态为done
r($plan->updateStatus($planId[0], $planId[3], $planId[6])) && p() && e('1'); //修改状态为closed
?>
