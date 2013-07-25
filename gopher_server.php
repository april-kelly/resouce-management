<?php
/**
 *  Name:       Basic Gopher Server
 *  Programmer: Liam Kelly
 *  Date: 
 */

set_time_limit(0);

$server = stream_socket_server("tcp://127.0.0.1:70", $errno, $errorMessage);

if ($server === false) {
    throw new UnexpectedValueException("Could not bind to socket: $errorMessage");
}

a:
echo "Gopher server ready...\r\n";

for (;;) {
    $client = @stream_socket_accept($server);

    if ($client) {
        echo "Client connected\r\n";
        stream_socket_sendto($client, file_get_contents('./gophermap'));
        stream_socket_sendto($client, "\r\n.");
        echo "Disconnected \r\n";
        break;
    }
}
fclose($client);
goto a;

