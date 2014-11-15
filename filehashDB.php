#!/usr/bin/php
<?php
/**
 * filehashDB --
 *    Simple file hash storage script, used to check if files have changed.
 *
 * @author trick <trick.developer@gmail.com>
 * @package filehashDB
 * @namespace filehashDB
 *
 * @version 1.0
 * @license MIT
 *
The MIT License (MIT)

Copyright (c) 2014 Patrick Organ <trick.developer@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
 */

 /*
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
define('DATABASE_FILE',       'filehashDB-HashDBXml.xml');
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

$db = new HashDBXml(DATABASE_FILE_FQ);
$db->load();

$fh = new FileHashSHA1($filename);
$compareHash = $db->compareHash($fh);

echo ($compareHash ? 'unchanged' : 'changed') . PHP_EOL;
if (!$compareHash)
  $db->setHash($fh);

$db->save();

exit( ($compareHash ? 0 : 1) );