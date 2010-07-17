<?php

/*
  ptkFile class
  
  description:
    PHP Toolkit File class for files/directories manipulation
    e.g.  $f = new ptkFile('/path/to/file'); $f->copy('/new/location');

  usage:

  @author     Tomasz Sobczak (http://tomaszsobczak.com)
  @package    PHP Toolkit (http://github.com/tomaszsobczak/php-toolkit)
  @subpackage libs
*/

class ptkFile
{
  private $file_location  = null;
  private $file_exists    = false;
  
  //  ---------------------------------------------------------------------- __construct
  public function __construct($file_location)
  {
    $this->file_location  = $file_location;
    $this->file_exists    = file_exists($this->file_location);
  }
  
  //  ---------------------------------------------------------------------- copy
  public function copy($destination)
  {
    if(!$this->_exists())
    { return false; }
    
    return copy($this->file_location, $destination);
  }

  //  ---------------------------------------------------------------------- move
  public function move($destination)
  {
    if(!$this->_exists())
    { return false; }
    
    if($ret = rename($this->file_location, $destination))
    { $this->file_location = $destination; }
    
    return $ret;

  //  ---------------------------------------------------------------------- delete
  public function delete()
  {
    if(!$this->_exists())
    { return false; }
    
    if($ret = unlink($this->file_location))
    { $this->file_exists = false; }
    
    return $ret;
  }
  
  //  ---------------------------------------------------------------------- private  methods
  //  ---------------------------------------------------------------------- _exists
  private function _exists()
  { return $this->file_exists; }
}

?>
