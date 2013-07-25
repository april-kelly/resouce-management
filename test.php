<?php
# server.php

set_time_limit(0);

$server = stream_socket_server("tcp://127.0.0.1:70", $errno, $errorMessage);

if ($server === false) {
    throw new UnexpectedValueException("Could not bind to socket: $errorMessage");
}

a:

for (;;) {
    $client = @stream_socket_accept($server);

    if ($client) {
        echo "Client connected\r\n";
        stream_socket_sendto($client, file_get_contents('./gophermap'));
        //stream_socket_sendto($client, "<b>Testing</b>");
        stream_socket_sendto($client, "\r\n.");
        echo "Disconnected \r\n";
        //stream_copy_to_stream($client, $client);
        break;
    }
}
fclose($client);
//goto a;
//gopher://localhost/resouce-management/test.php
