# Retroarch PHP playlist creator

 Retroarch PHP playlist creator is a php script to create a playlist for Retroarch starting from a directory. It works with subdirectories and filter file extensions

## Installation

You must have PHP 7 or above installed.

## Usage

Edit these lines:

```PHP
/* Config Here */
$initial_dir = __DIR__ . DIRECTORY_SEPARATOR; //directory that will scan
$playlist_name = "LISTNAME.lpl"; //playlistname
$db_name = "Sony - PlayStation.lpl"; //Dbname
$allowed = array("bin","cue"); //include extensions that you want to put in your playlist
/*END CONFIG */
```
## Run

```bash
php script.php
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
