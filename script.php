<?php

function searchArcadeGame($name){
   $pdo = $GLOBALS['pdo'];
   $query = "SELECT description FROM game WHERE name = :name";
   $rs = $pdo->prepare($query);
   $rs->bindValue(':name',$name,PDO::PARAM_STR);
   $rs->execute();
   if($rows = $rs->fetch(PDO::FETCH_ASSOC)){
      return $rows['description'];
   }else{
      return $name;
   }
}


function isBios($name){
   $pdo = $GLOBALS['pdo'];
   $query = "SELECT description FROM game WHERE name = :name 
                                                                               and (upper(description) like '%BIOS%'
                                                                                       or upper(description) like '%SYS%'
                                                                                       or upper(description) like '%SYSTEM%'
                                                                                       or upper(description) like '%CHIP%' 
                                                                                       or upper(description) like '%FIRMWARE%'
                                                                                      )                                                                                       
                                                                               ";
   $rs = $pdo->prepare($query);
   $rs->bindValue(':name',$name,PDO::PARAM_STR);
   $rs->execute();
   if($rows = $rs->fetch(PDO::FETCH_ASSOC)){
      return TRUE;
   }else{
      return FALSE;
   }
}


function addArchive($dir, $playlist_name, $allowed)
{
    $files = array();
    $d = dir($dir);
    while (false !== ($entry = $d->read())) {
        echo "Checking " . $dir . $entry . "\n";
        $dir_name = $dir . $entry . DIRECTORY_SEPARATOR;
        if (is_dir($dir_name)) {
            if (($entry != ".") && ($entry != "..")) {
                $files = array_merge($files, addArchive($dir_name, $playlist_name, $allowed));
            }
        } else {
           $file_name = pathinfo($dir . $entry, PATHINFO_FILENAME);
            if($GLOBALS['jump_bios'] && $GLOBALS['is_arcade'] && isBios($file_name)  )
              continue;

            if (in_array(pathinfo($dir . $entry, PATHINFO_EXTENSION), $allowed)) {
                $files[] = array('path' => $dir . $entry,
                    'label' => !$GLOBALS['is_arcade'] ? $file_name : searchArcadeGame($file_name ),
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
$initial_dir = __DIR__ . DIRECTORY_SEPARATOR;
$playlist_name = "PSX.lpl"; //Playlist name
$db_name = "PSX.lpl"; //Database to serch the images
$allowed = array("pbp","bin"); //Add all of extensions that you want o put in playlist, is case sensitive
$is_arcade = FALSE; //Set TRUE if the playlist is for arcade YOU MUST HAVE THE mame.sqlite in the same folder
$jump_bios = TRUE; //Jump BIOS files, works only for arcade
/*END CONFIG */


if($is_arcade){
   $pdo = new PDO('sqlite:mame.sqlite', null, null); 
}else{
   $pdo = null;
}



$playlist = array();
$playlist['version'] = "1.0";
$playlist['items'] = addArchive($initial_dir, $playlist_name, $allowed);

file_put_contents($playlist_name, str_replace('  "version": "1.0",', '"version": "1.0",', json_encode($playlist, JSON_PRETTY_PRINT)));
