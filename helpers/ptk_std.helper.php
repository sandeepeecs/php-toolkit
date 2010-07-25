<?php

/*
  PHP Toolkit Standard helpers library

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage Helpers
*/

//  ---------------------------------------------------------------------- run_recursive
function run_recursive($method, $data)
{
  if(is_array($data))
  {
    foreach($data as $k => $v)
    { $data[$k] = run_recursive($method, $v); }
    
    return $data;
  }
  
  return $method($data);
}

?>
