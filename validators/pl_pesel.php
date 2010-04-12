<?php

/*
  Polish PESEL (Powszechny Elektroniczny System Ewidencji Ludności) validator,
  PESEL stands for Universal Electronic System for Registration of the Population

  usage:
    $ret    = is_valid_pesel('81102004691');            //  to validate
    $gender = get_gender_from_pesel('81102004691');     //  to get person gender  (m => male, f => female)
    $bdate  = get_birthdate_from_pesel('81102004691');  //  to get person birthdate

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage Validators
*/

define('PESEL_MODULO_DIVISOR', 10);

function is_valid_pesel($pesel)
{
  $pesel_digits = _pesel_digits($pesel);
  $pesel_sum    = 0;
  
  if(11 != count($pesel_digits))
  { return false; }
  
  foreach(array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3) as $weight)
  { $pesel_sum += $weight * array_shift($pesel_digits); }
    
  return (0 == ($pesel_mod = ($pesel_sum % PESEL_MODULO_DIVISOR))) ? (0 == array_shift($pesel_digits)) : ($pesel_mod == (10 - array_shift($pesel_digits)));
}

function get_gender_from_pesel($pesel)
{
  if(false == is_valid_pesel($pesel))
  { return null; }
  
  return (1 == (array_slice(_pesel_digits($pesel), 9, 1) % 2)) ? 'm' : 'f';
}

function get_birthdate_from_pesel($pesel, $format = 'Y-m-d')
{
  if(false == is_valid_pesel($pesel))
  { return null; }
  
  $pesel_digits = _pesel_digits($pesel);
  $pesel_year   = implode('', array_slice($pesel_digits, 0, 2));
  $pesel_month  = implode('', array_slice($pesel_digits, 2, 2));
  $pesel_day    = implode('', array_slice($pesel_digits, 4, 2));
  
  switch($pesel_month/20)
  {
    case 4:
      $pesel_month  = $pesel_month % 80;
      $pesel_year   += 1800;
      break;
    case 3:
      $pesel_month  = $pesel_month % 60;
      $pesel_year   += 2200;
      break;
    case 2:
      $pesel_month  = $pesel_month % 40;
      $pesel_year   += 2100;
      break;
    case 1:
      $pesel_month  = $pesel_month % 20;
      $pesel_year   += 2000;
      break;
    default:
      $pesel_year   += 1900;
      break;
  }
  
  return date($format, mktime(0, 0, 0, $pesel_month, $pesel_day, $pesel_year));
}

function _pesel_digits($pesel)
{ return array_filter(preg_split('//', $pesel, -1, PREG_SPLIT_NO_EMPTY), 'is_numeric'); }

?>
