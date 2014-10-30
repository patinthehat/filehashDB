<?php
/**
 * HashDB --
 *    Implementation of the hash database using .ini files.
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

class HashDB {

  protected $filename;
  protected $data;


  /**
   * Writes $data to the HashDB filename.
   * Returns TRUE on successful write, FALSE on failure or bad filename.
   *
   * @param string $data
   * @return boolean
   */
  protected function write($data) {
    if (strlen($this->filename) > 0) {
      file_put_contents($this->filename, $data);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Initializes the HashDB file.  Called by HashDB->load().
   */
  protected function init() {
    if (!file_exists($this->filename))
      $this->write("[db]\n");
  }

  public function __construct($filename) {
    $this->filename = $filename;
  }

  /**
   * Loads the HashDB->filename.
   */
  public function load() {
    $this->init();
    $this->data = parse_ini_file($this->filename);
  }


  /**
   * Saves the current database data to HashDB->filename.
   * Changes to the database are NOT saved automatically. save() must be called or changes will be lost.
   * @param boolean $sorted TRUE to sort the database, FALSE to leave the way it is.
   */
  public function save($sorted = TRUE) {
    $output = "[db]\n";
    if ($sorted)
      ksort($this->data);

    foreach($this->data as $n=>$hash) {
      if ($hash !== 0)
        $output .= "$n=$hash\n";
    }

    $this->write($output);
  }

  /**
   * Returns the filename of the database file.
   */
  public function getDatabaseFilename() {
    return $this->filename;
  }

  /**
   * Retrieves the stored hash of the specified filename.
   * @param string $filename
   * @return string Returns the stored hash.
   */
  public function getHash($filename) {
    if (!isset($this->data[$filename]))
      return FALSE;
    return $this->data[$filename];
  }

  /**
   * Compares the stored hash with the FileHash hash.
   * @param FileHash $fh
   * @return boolean Returns TRUE if the hashes match, FALSE if they are different.
   */
  public function compareHash(FileHash $fh) {
    $oldhash = $this->getHash($fh->getFilename());
    return ($oldhash === $fh->getHash());
  }

  /**
   * Stores the hash and filename specified by FileHash.  Overwrites the stored hash, if it exists.
   * @param FileHash $fh
   */
  public function setHash(FileHash $fh) {
    $fn = $fh->getFilename();
    $hash = $fh->getHash();
    $this->data[$fn] = $hash;
  }

  /**
   * Removes the specified file from the database.
   * @param string $filename
   * @return boolean Returns TRUE on success, or FALSE if the file was not found in the database.
   */
  public function removeFile($filename) {
    if (isset($this->data[$filename])) {
      unset($this->data[$filename]);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Dumps the current database data to the console.  The data dumped is not what has been saved, but what is stored in memory.
   */
  public function dump() {
    print_r($this->data);
  }
}