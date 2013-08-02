<?php
/**
 *  Name:       Basic Gopher Server
 *  Programmer: Liam Kelly
 *  Date:       7/26/13
 */

//includes
require_once('../path.php');
require_once(ABSPATH.'includes/view.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

set_time_limit(0);

//Fetch settings
$set = new settings;
$settings = $set->fetch();

$server = stream_socket_server("tcp://".$settings['domain'].":70", $errno, $errorMessage);

if ($server === false) {
    throw new UnexpectedValueException("Could not bind to socket: $errorMessage");
}

echo "Gopher server ready...\r\n";
//Let the rest the application know the server is running
$set = new settings;
$settings = $set->fetch();
$settings['gopher'] = TRUE;
$set->update($settings);

a:


for (;;) {
    $client = @stream_socket_accept($server);



    if ($client) {

        $read = stream_socket_recvfrom($client, '4');

        if($read == "\r\n"){
        echo 'Gopher client connected'."\r\n";
        stream_socket_sendto($client, file_get_contents('gophermap'));
        stream_socket_sendto($client, "\r\n.");
        echo 'Gopher client disconnected'." \r\n";
        break;
        }else{
            echo 'Telnet client connected';
        }

        if($read == 'stop'){
            echo 'Telnet client disconnected';
            stream_socket_sendto($client, "Gopher server stopped.\r\n");
            goto b;
        }

        if($read == 'quit'){
            echo 'Telnet client disconnected';
            stream_socket_sendto($client, "Disconnected from Gopher server.\r\n");
            break;
        }

        if($read == 'help'){
            echo 'Telnet client disconnected';
            stream_socket_sendto($client, "PHP Gopher Server v1.0.\r\n");
            stream_socket_sendto($client, "By: Liam Kelly\r\n");
            stream_socket_sendto($client, "(C) Copyright 2013 Bluetent Marketing\r\n");
            stream_socket_sendto($client, "ALL RIGHTS RESERVED\r\n");
            break;
        }


    }

}
fclose($client);
goto a;

b:
//Let the rest the application know the server is running
$set = new settings;
$settings = $set->fetch();
$settings['gopher'] = FALSE;
$set->update($settings);
fclose($client);
