# Laravel Mqtt Publisher
Mqtt is used to publish messages from backend to andriod.

### Getting start
`
    composer require luzhuqun/laravel-mqtt-publish
`
### How to use
`
//create a new connection object
    $conn = new SAMConnection();

//start initialise the connection
    $conn->connect('mqtt', array('SAM_HOST' => '192.168.10.147', 'SAM_PORT' => '1883'));

//create a new MQTT message with the output of the shell command as the body
    $msgCpu = new SAMMessage('hehe');

//send the message on the topic cpu
    $conn->send('topic://'.'tokudu/ab7867d9fd60db65', $msgCpu);

    $conn->disconnect();
`
### Learn more
A complet mqtt service incluede publisher, service and subscriber.
##### service 
[mosquitto](https://github.com/eclipse/mosquitto)
##### subscriber
[AndroidPushNotificationsDemo](https://github.com/tokudu/AndroidPushNotificationsDemo)
