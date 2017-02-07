<?php
require_once dirname(__DIR__) . '/src/Config.php';

use SimpleConfig\Config;

$key = 'abc.xyz';
echo Config::create()->get($key, "hi") . PHP_EOL;

$configObj = Config::create();
$configObj['user.jifen'] = 100;
Config::create()->set("x.y.z", "how are you?");
echo Config::create()->get("x.y.z", "hixyz") . PHP_EOL;
echo Config::create()->get("user.jifen", "0") . PHP_EOL;

echo Config::create()->has('x.y')?"true":'false';
echo PHP_EOL;
echo Config::create()->has('who.x.y')?"true":'false';
echo PHP_EOL;
echo isset($configObj['x.y'])?"true":'false';
echo PHP_EOL;

Config::create()->del("x.y.z"); //unset($configObj['x.y.z']);
echo Config::create()->get("x.y.z", "hixyz") . PHP_EOL;

var_export(Config::create()->getAll());
echo PHP_EOL;
