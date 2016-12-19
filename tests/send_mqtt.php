<?php
require('etc/config.php');
require('lib/php_sam.php');

//create a new connection object
$conn = new SAMConnection();

//start initialise the connection
$conn->connect(SAM_MQTT, array(SAM_HOST => MQTT_SERVER_HOST, SAM_PORT => MQTT_SERVER_POST));

//create a new MQTT message with the output of the shell command as the body
$msgCpu = new SAMMessage($_REQUEST['message']);

//send the message on the topic cpu
$conn->send('topic://'.$_REQUEST['target'], $msgCpu);
         
$conn->disconnect();         

echo 'MQTT Message to ' . $_REQUEST['target'] . ' sent: ' . $_REQUEST['message']; 
?>