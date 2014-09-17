
###Usage###

####Using filehashDB.php#####
<em>Before using, make sure you have run `chmod +x filehashDB.php`.  
The database file will be created automatically when filehashDB is run.</em>

Usage is fairly simple.  Execute the following: <br>
&nbsp;&nbsp;&nbsp;&nbsp;`$ filehashDB.php [filename]`<br>
and it will add the current file hash.  The exit code will be 0 if the hash was unchanged, and 1 if the hash was different than the previously stored hash <em>(or did not exist in the database)</em>.

####Hashing Method####
By default, filehashDB uses SHA1 to hash files.  MD5 can be implemented with minor code changes for a ~50% speed increase. <br>
In `filehashDB.php`, change the `new FileHashSHA(...` line to `new FileHashMD5(...`.

####Using the filehashDB classes####

By default, filehashDB uses ini files to store the file hash information.  To implement a different method of storage, override the `HashDB` class.

- more to come.

---
###Classes###

  - `FileHash` - Abstract class that calculates the hash for a file.
  - `FileHashMD5` - MD5 hash implementation.
  - `FileHashSHA1` - SHA1 hash implementation.
  - `HashDB` - The main database class, handling loading, saving, and comparing of hashes.
  
  
---
###License###
filehashDB is available under the <a href="LICENSE">MIT License</a>.