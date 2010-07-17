<?php

/*
  International Bank Account Number (IBAN) validator

  usage:
    $ret = is_valid_iban('78 1140 2004 0000 3102 4463 3880', 'PL');

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage Validators
*/

define('PTK_IBAN_CONTROL_VALUE',  1);
define('PTK_IBAN_DIVISOR_VALUE',  97);

function is_valid_iban($iban, $country_prefix)
{
  $l2d  = array(
    'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13,
    'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17,
    'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21,
    'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25,
    'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29,
    'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33,
    'Y' => 34, 'Z' => 35
  );
  
  $iban = implode('', array_filter(preg_split('//', $iban, -1, PREG_SPLIT_NO_EMPTY), 'is_numeric'));
  $iban = $country_prefix . $iban;
  $iban = substr($iban, 4) . substr($iban, 0, 4);
  $iban = str_replace(array_keys($l2d), array_values($l2d), $iban);
  
  return (PTK_IBAN_CONTROL_VALUE == _iban_modulo($iban));
}

function _iban_modulo($in, $prepend = null)
{
  if(!is_null($prepend))
  { $in = $prepend . $in; }
  
  if(8 < strlen($in))
  {
    $iban_part    = substr($in, 0, 7);
    $iban_modulo  = $iban_part % PTK_IBAN_DIVISOR_VALUE;

    return _iban_modulo(substr($in, 7), $iban_modulo);
  }
  
  return $in % PTK_IBAN_DIVISOR_VALUE;
}

?>
