<?php
require "vendor/autoload.php";

use Lzq\Mqtt\SamConnection;
use Lzq\Mqtt\SamMessage;

//create a new connection object
$conn = new SAMConnection();

//start initialise the connection
$conn->connect('mqtt', array('SAM_HOST' => '192.168.10.147', 'SAM_PORT' => '1883'));

//create a new MQTT message with the output of the shell command as the body
$msgCpu = new SAMMessage('hehe');

//send the message on the topic cpu
$conn->send('topic://'.'tokudu/ab7867d9fd60db65', $msgCpu);

$conn->disconnect();