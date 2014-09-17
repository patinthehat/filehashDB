<?php

/**
 * Includes a file if it exists.
 * Returns TRUE if the file was successfully included, or FALSE if the file was not found.
 * @param string $fn Filename to include
 * @return boolean 
 */
function include_if_exists($fn) {
  if (file_exists($fn)) {
    include_once($fn);
    return TRUE;
  }
  return FALSE;
}

function filehashDB_autoload($className) {
  include_if_exists(THIS_SCRIPT_PATH."/classes/${className}.php");    
}

spl_autoload_register('filehashDB_autoload');