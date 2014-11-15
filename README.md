##filehashDB##

filehashDB stores file hashes that can be checked at a later time to see if they have changed.  This can be used, for example, to automatically re-compress CSS or javascript files on a website.
_See "Hashing Method" below._

By default, filehashDB uses _INI_ files to store the file hashes.  To use XML files, change `HashDBIni` to `HashDBXml` in _`filehashDB.php`_.

---


###Usage###

####Using filehashDB#####
_Before using, make sure you have run `$ chmod +x filehashDB.php`.  
The database file will be created automatically when filehashDB is run._

Usage is fairly simple.  Execute the following: <br>
&nbsp;&nbsp;&nbsp;&nbsp;`$ filehashDB.php [filename]`<br>
and it will add the current file hash.  

The exit code will be 0 if the hash was unchanged, and 1 if the hash was different than the previously stored hash <em>(or did not exist in the database)</em>.

####Hashing Method####

By default, filehashDB uses SHA1 to hash files.  MD5 can be implemented with minor code changes for a ~50% speed increase. <br>
In `filehashDB.php`, change the `new FileHashSHA(...` line to `new FileHashMD5(...`.


####Storage####
The `BaseHashDB` class should be extended to implement a specific storage engine.  By default, filehashDB includes INI and XML storage engines.

####Using the filehashDB classes####

By default, filehashDB uses ini files to store the file hash information.  To implement a different method of storage, override the `BaseHashDB` class.

  - To use the _INI_ storage engine, use the `HashDBIni` class.
  - To use the _XML_ storage engine, use the `HashDBXml` class.  

---
###Classes###

  - `FileHash` - Abstract class that calculates the hash for a file.
  - `FileHashMD5` - MD5 hash implementation.
  - `FileHashSHA1` - SHA1 hash implementation.
  - `BaseHashDB` - Base Database class, to be extended by child classes that implement various storage engines.
  - `HashDBIni` - Database class, handling loading, saving, and comparing of hashes using ini files.
  - `HashDBXml` - Database class, handling loading, saving, and comparing of hashes using XML files.  
  
---

####Implementing filehashDB####

To implement filehashDB in a PHP project, use code similar to the following:

```php
include('filehashDB/autoload.php');

$filename = "file-to-hash.txt";
$db = new HashDBXml("db.xml");
$db->load();

$fh = new FileHashSHA1($filename);
$compareHash = $db->compareHash($fh);

echo ($compareHash ? 'unchanged' : 'changed') . PHP_EOL;
if (!$compareHash)
  $db->setHash($fh);

$db->save();
```
  
---

###License###
filehashDB is available under the <a href="LICENSE">MIT License</a>.