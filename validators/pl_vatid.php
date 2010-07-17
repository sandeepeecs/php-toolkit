<?php

/*
  Polish VATID validator

  usage:
    $ret = is_valid_vatid('749-179-91-62');

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage Validators
*/

define('PTK_VATID_MODULO_DIVISOR', 11);

function is_valid_vatid($vatid)
{
  $vatid_digits  = array_filter(preg_split('//', $vatid, -1, PREG_SPLIT_NO_EMPTY), 'is_numeric');
  $vatid_length  = count($vatid_digits);
  $vatid_sum     = 0;

  if(10 != $vatid_length)
  { return false; }

  foreach(array(6, 5, 7, 2, 3, 4, 5, 6, 7) as $weight)
  { $vatid_sum += $weight * array_shift($vatid_digits); }
    
  return (($vatid_sum % PTK_VATID_MODULO_DIVISOR) == array_shift($vatid_digits));
}

?>
