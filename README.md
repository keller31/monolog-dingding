# monolog-dingding
Monolog Handler for Dingding Robot
<p>
<a href="https://packagist.org/packages/keller31/monolog-dingding"><img src="https://poser.pugx.org/keller31/monolog-dingding/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/keller31/monolog-dingding"><img src="https://poser.pugx.org/keller31/monolog-dingding/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/keller31/monolog-dingding"><img src="https://poser.pugx.org/keller31/monolog-dingding/license.svg" alt="License"></a>
</p>

[![StyleCI](https://github.styleci.io/repos/149638859/shield?branch=master)](https://github.styleci.io/repos/149638859?branch=master)

使用钉钉机器人发送monolog日志事件通知

## 安装

```bash
composer require keller31/monolog-dingding
```

## 使用方法
- 首先请获取钉钉机器人的 `access_token` :
- 设置Handler：
```php
$logger = new Logger('dingding');
$handler = new \keller31\MonologDingding\DingdingRobotHandler(Logger::ALERT,$access_token);
$logger->pushHandler($handler);
```


- 发送dingding机器人消息:

```php
$logger->alert('你好吗!');
```

