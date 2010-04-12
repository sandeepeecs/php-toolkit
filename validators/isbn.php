<?php

/*
  International Standard Book Number (ISBN) validator,
  both ISBN length (10 and 13) are supported

  usage:
    $ret = is_valid_isbn('83-7361-338-2');

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage Validators
*/

define('ISBN_10_MODULO_DIVISOR', 11);
define('ISBN_13_MODULO_DIVISOR', 10);

function is_valid_isbn($isbn)
{
  $isbn_digits  = array_filter(preg_split('//', $isbn, -1, PREG_SPLIT_NO_EMPTY), '_is_numeric_or_x');
  $isbn_length  = count($isbn_digits);
  $isbn_sum     = 0;

  if((10 != $isbn_length) && (13 != $isbn_length))
  { return false; }

  if(10 == $isbn_length)
  {
    foreach(range(1, 9) as $weight)
    { $isbn_sum += $weight * array_shift($isbn_digits); }
    
    return (10 == ($isbn_mod = ($isbn_sum % ISBN_10_MODULO_DIVISOR))) ? ('x' == mb_strtolower(array_shift($isbn_digits), 'UTF-8')) : ($isbn_mod == array_shift($isbn_digits));
  }
  
  if(13 == $isbn_length)
  {
    foreach(array(1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 1, 3) as $weight)
    { $isbn_sum += $weight * array_shift($isbn_digits); }
    
    return (0 == ($isbn_mod = ($isbn_sum % ISBN_13_MODULO_DIVISOR))) ? (0 == array_shift($isbn_digits)) : ($isbn_mod == (10 - array_shift($isbn_digits)));
  }
  
  return false;
}

function _is_numeric_or_x($val)
{ return ('x' == mb_strtolower($val, 'UTF-8')) ? true : is_numeric($val); }

?>
