<?php
/**
 * Created by PhpStorm.
 * User: keller
 * Date: 2018/9/21
 * Time: 00:40
 */

namespace keller31\MonologDingding;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;


/**
 * Class DingdingRobotHandler
 * @package keller\MonologDingding
 */
class DingdingRobotHandler extends AbstractProcessingHandler
{
	public $access_token;

	/**
	 * DingdingRobotHandler constructor.
	 * @param $level
	 * @param string $access_token
	 */
	public function __construct($level = Logger::ALERT, $access_token = '')
	{
		parent::__construct($level);
		$this->access_token = $access_token;

	}

	/**
	 * @param array $record
	 */
	public function write(array $record)
	{
		$message['msgtype']         = 'text';
		if (strpos($record['message'], '@') !== false) {
		    preg_match_all('/(\@(\d{11}|所有人))/u', $record['message'], $ats);
		    if ($ats[1]) {
		        $record['message'] = str_replace($ats[1], '', $record['message']);
		        foreach ($ats[2] as $at){
		            if ($at == '所有人') {
		                $message['at']['isAtAll'] = true;
		                break;
		            } else {
		                $message['at']['atMobiles'] = $ats[2];
		            }
		        }
		    }
		}
		$message['text']['content'] = $record['channel'].'.'.$record['level_name'].PHP_EOL.$record['message'].PHP_EOL.json_encode($record['context'],JSON_UNESCAPED_UNICODE);
		$this->dd_robot($message);
	}

	/**
	 * @param $message
	 * @return mixed
	 */
	private function dd_robot($message)
	{
		$webhook     = "https://oapi.dingtalk.com/robot/send?access_token=" . $this->access_token;
		$message = json_encode($message);
		$ch          = curl_init();
		curl_setopt($ch, CURLOPT_URL, $webhook);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


}