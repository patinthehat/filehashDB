<?php


function filehashDB_autoload($className) {
  if (file_exists("classes/${className}.php"))
    include_once("classes/${className}.php");
    
}


spl_autoload_register('filehashDB_autoload');