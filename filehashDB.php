#!/usr/bin/php
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

define('DATABASE_PATH',       dirname(realpath($argv[0])));
define('DATABASE_FILE',       'filehashDB.ini');
define('DATABASE_FILE_FQ',    DATABASE_PATH."/".DATABASE_FILE);
define('THIS_SCRIPT',         basename($argv[0]));
define('THIS_SCRIPT_PATH',    dirname(realpath($argv[0])));

include_once('autoload.php');

function usage() {
  echo "Usage: ".THIS_SCRIPT." [filename]" . PHP_EOL;
  echo "  Exit value is 0 if hash is unchanged, or 1 if the file hash has changed." . PHP_EOL; 
  echo PHP_EOL;
}

if ($argc <= 1) {
  usage();
  exit(-1);
}

$filename = realpath($argv[1]);

$db = new HashDB(DATABASE_FILE_FQ);
$db->load();

$fh = new FileHashSHA1($filename);
$compareHash = $db->compareHash($fh);

echo ($compareHash ? 'unchanged' : 'changed') . PHP_EOL;
if (!$compareHash)
  $db->setHash($fh);

$db->save();

exit( ($compareHash ? 0 : 1) );