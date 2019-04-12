# Retroarch PHP playlist creator

 Retroarch PHP playlist creator is a php script to create a playlist for Retroarch starting from a directory. It works with subdirectories and filter file extensions

## Installation

You must have PHP 7 or above installed.
For Arcade, Must have PDO and PDOSQLITE php extensions on

## Dependences
mame.dat (https://github.com/iytt/mame.dat)
Included in this repository, don't worry :))

## Usage

Edit these lines:

```PHP
/* Config Here */
$initial_dir = __DIR__ . DIRECTORY_SEPARATOR;
$playlist_name = "PSX.lpl"; //Playlist name
$db_name = "PSX.lpl"; //Database to serch the images
$allowed = array("pbp","bin"); //Add all of extensions that you want o put in playlist, is case sensitive
$is_arcade = FALSE; //Set TRUE if the playlist is for arcade YOU MUST HAVE THE mame.sqlite in the same folder
$jump_bios = TRUE; //Jump BIOS files, works only for arcade
/*END CONFIG */
```
## Run

```bash
php script.php
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
