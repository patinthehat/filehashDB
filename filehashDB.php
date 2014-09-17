<?php
/**
 *
 * Hash function times:
 *    [md5]  => 0.0044631958007812
 *    [sha1] => 0.0082240104675293
 *
 * FileHash classes:
 *    FileHashMD5
 *    FileHashSHA1
 *
 */

define('DATABASE_PATH',     dirname(realpath($argv[0])));
define('DATABASE_FILE',     'filehashDB.ini');
define('DATABASE_FILE_FQ',  DATABASE_PATH."/".DATABASE_FILE);


include('autoload.php');
//include('print_r_compressed.php');

echo DATABASE_FILE_FQ . "\n";

$db = new HashDB(DATABASE_FILE_FQ);
$db->load();

$fh = new FileHashSHA1("/etc/passwd");
$compareHash = $db->compareHash($fh);

echo ($compareHash ? 'unchanged' : 'changed') . PHP_EOL;
if (!$compareHash)
  $db->setHash($fh);

$db->save();

$db->dump();

exit(0);


$hfdata = array();
$data = file_get_contents("/etc/passwd");

foreach(hash_algos() as $v) {
  $time=microtime(1);
  for ($i = 0; $i < 1000; $i++) {
    $hfdata[$v]['length'] = strlen(hash($v, $data.$i, false));
  } 
  $hfdata[$v]['time'] = (microtime(1)-$time) ;
}


print_r($hfdata);