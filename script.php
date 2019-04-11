<?php
function addArchive($dir, $playlist_name, $allowed)
{
    $files = array();
    $d = dir($dir);
    while (false !== ($entry = $d->read())) {

        echo "Checking " . $dir . $entry . "\n";
        if (is_dir($dir . $entry . DIRECTORY_SEPARATOR)) {
            if (($entry != ".") && ($entry != "..")) {
                $files = array_merge($files, addArchive($dir . $entry . DIRECTORY_SEPARATOR, $playlist_name, $allowed));
            }
        } else {

            if (in_array(pathinfo($dir . $entry, PATHINFO_EXTENSION), $allowed)) {
                $files[] = array('path' => $dir . $entry,
                    'label' => pathinfo($dir . $entry, PATHINFO_FILENAME),
                    'core_path' => 'DETECT',
                    'core_name' => 'DETECT',
                    'crc32' => "",
                    'db_name' => $GLOBALS['db_name'],
                );

                echo "Adding " . $dir . $entry . "\n";
            }
        }
    }
    $d->close();
    return $files;
}

/* Config Here */
$initial_dir = __DIR__ . DIRECTORY_SEPARATOR; //directory that will scan
$playlist_name = "LISTNAME.lpl"; //playlistname
$db_name = "Sony - PlayStation.lpl"; //Dbname
$allowed = array("bin","cue"); //include extensions that you want to put in your playlist
/*END CONFIG */


$playlist = array();
$playlist['version'] = "1.0";
$playlist['items'] = addArchive($initial_dir, $playlist_name, $allowed);

file_put_contents($playlist_name, str_replace('  "version": "1.0",', '"version": "1.0",', json_encode($playlist, JSON_PRETTY_PRINT)));
