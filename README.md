###Classes###

  - `FileHash` - Abstract class that calculates the hash for a file.
  - `FileHashMD5` - MD5 hash implementation.
  - `FileHashSHA1` - SHA1 hash implementation.
  - `HashDB` - The main database class, handling loading, saving, and comparing of hashes.
  
  
---
###Usage###

####Using filehashDB.php#####
Usage is fairly simple, call `filehashDB.php [filename]` and it will add the current file hash.  The exit code will be 0 if the hash was unchanged, and 1 if the hash was different than the previously stored hash.

####Using the filehashDB classes####

- `todo`

---
###License###
filehashDB is available under the <a href="LICENSE">MIT License</a>.