<?php
/**
 * The zanode entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuchun Li <liyuchun@easycorp.ltd>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class zanodeHeartbeatEntry extends baseEntry
{
    /**
     * Listen vm heartbeat.
     *
     * @param  int|string $userID
     * @access public
     * @return void
     */
    public function post()
    {
        /* Check authorize. */
        $header = getallheaders();
        $token  = isset($header['Authorization']) ? substr($header['Authorization'], 7) : '';
        $secret = isset($this->requestBody->secret) ? $this->requestBody->secret : '';
        if(!$secret and !$token) return $this->sendError(401, 'Unauthorized');
        
        /* Check param. */
        $status = isset($this->requestBody->status) ? $this->requestBody->status : '';
        $mac    = isset($this->requestBody->macAddress) ? $this->requestBody->macAddress : '';
        $now    = helper::now();
        if(!$status || !$mac) return $this->sendError(400, 'Params error.');

        $this->dao = $this->loadModel('common')->dao;
        $host = $this->dao->select('id,extranet')->from(TABLE_ZAHOST)
            ->beginIF($secret)->where('secret')->eq($secret)->fi()
            ->beginIF(!$secret)->where('tokenSN')->eq($token)
            ->andWhere('tokenTime')->gt($now)->fi()
            ->fetch();
        if(empty($host)) return $this->sendError(400, 'Secret error.');

        $node = $this->dao->select('id,parent')->from(TABLE_ZAHOST)
            ->where('mac')->eq($mac)
            ->fetch();
            
        if(empty($node) || ($node->parent != $host->id && $node->id != $host->id)) return $this->sendError(400, 'Secret error.');

        $node->zap       = $this->requestBody->agentPortOnHost;
        $node->status    = $this->requestBody->status;

        if($secret)
        {
            $node->tokenSN     = md5($secret . $now);
            $node->tokenTime   = date('Y-m-d H:i:s', time() + 7200);
        }

        $this->dao->update(TABLE_ZAHOST)->data($node)->where('id')->eq($node->id)->exec();

        if($secret)
        {
            //install services
            $node->ip = $host->extranet;
            $nodeStatus = $this->loadModel('zanode')->getServiceStatus($node);
            if($nodeStatus['ZTF'] != "ready")
            {
                $node->secret = $secret;
                $node->extranet = $host->extranet;
                $this->loadModel('zanode')->installService($node, "ZTF");
            }
        }
        
        if(!$secret) return $this->sendSuccess(200, 'success');

        $node->tokenTimeUnix = strtotime($node->tokenTime);

        unset($node->status);
        unset($node->tokenTime);
        return $this->send(200, $node);
    }
}
