<?php

/*
  Simple Port knocker implementation

  usage:
    php-knock.php   HOSTNAME  PORT1 PORT2 PORT3 ...

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage cli-tools
*/

foreach(array_slice($argv, 2) as $dst_port)
{
  $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            @socket_connect($socket, $argv[1], $dst_port);
            socket_close($socket);
}

?>
