REPLACE INTO `zt_report` (`code`, `name`, `module`, `sql`, `vars`, `langs`, `params`, `step`, `desc`, `addedBy`, `addedDate`) VALUES
('bug-resolve', '{\"zh-cn\":\"Bug\\u89e3\\u51b3\\u8868\",\"zh-tw\":\"Bug\\u89e3\\u6c7a\\u8868\",\"en\":\"Solved Bugs\"}', ',test', 'select *,if($product=\'\',0,product) as customproduct from TABLE_BUG where deleted=\'0\' and resolution!=\'\' and if($startDate=\'\',1,resolvedDate>=$startDate) and if($endDate=\'\',1,resolvedDate<=$endDate) having customproduct=$product', '{\"varName\":[\"product\",\"startDate\",\"endDate\"],\"showName\":[\"\\u4ea7\\u54c1\",\"\\u89e3\\u51b3\\u65e5\\u671f\\u5f00\\u59cb\",\"\\u89e3\\u51b3\\u65e5\\u671f\\u7ed3\\u675f\"],\"requestType\":[\"select\",\"date\",\"date\"],\"selectList\":[\"product\",\"user\",\"user\"],\"default\":[\"\",\"$MONTHBEGIN\",\"$MONTHEND\"]}', '{\"count\":{\"zh-cn\":\"\\u9700\\u6c42\\u6570\",\"zh-tw\":\"\\u9700\\u6c42\\u6570\",\"en\":\"Stories\"},\"done\":{\"zh-cn\":\"\\u5b8c\\u6210\\u6570\",\"zh-tw\":\"\\u5b8c\\u6210\\u6570\",\"en\":\"Done\"}}', '{\"group1\":\"resolvedBy\",\"isUser\":{\"group1\":[\"1\"]},\"group2\":\"\",\"reportField\":[\"resolution\"],\"reportType\":[\"count\"],\"sumAppend\":[\"\"],\"reportTotal\":[\"1\"],\"percent\":[\"1\"],\"contrast\":[\"crystalTotal\"],\"showAlone\":[\"1\"]}', 2, '{\"zh-cn\":\"\\u5217\\u51fa\\u89e3\\u51b3\\u7684Bug\\u603b\\u6570\\uff0c\\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u5206\\u5e03\\uff0c\\u5360\\u7684\\u6bd4\\u4f8b\\uff08\\u8be5\\u7528\\u6237\\u89e3\\u51b3\\u7684Bug\\u7684\\u6570\\u91cf\\u5360\\u6240\\u6709\\u7684\\u89e3\\u51b3\\u7684Bug\\u7684\\u6570\\u91cf)\\u3002\",\"zh-tw\":\"\\u5217\\u51fa\\u89e3\\u6c7a\\u7684Bug\\u7e3d\\u6578\\uff0c\\u89e3\\u6c7a\\u65b9\\u6848\\u7684\\u5206\\u5e03\\uff0c\\u5360\\u7684\\u6bd4\\u4f8b\\uff08\\u8a72\\u7528\\u6236\\u89e3\\u6c7a\\u7684Bug\\u7684\\u6578\\u91cf\\u5360\\u6240\\u6709\\u7684\\u89e3\\u6c7a\\u7684Bug\\u7684\\u6578\\u91cf)\\u3002\",\"en\":\"List the total number of bugs resolved, the distribution of solutions, and the percentage (the number of bugs solved by this user to the total number of bugs resolved).\"}', 'admin', '2015-07-24 13:44:25'),