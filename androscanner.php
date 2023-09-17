<?php
function scanr()
{

    
    shell_exec("fusermount -u /home/ax/MyAndroid");
    shell_exec("go-mtpfs /home/ax/MyAndroid");
    
    $Directory = new RecursiveDirectoryIterator("/home/ax/MyAndroid/");
    $Iterator = new RecursiveIteratorIterator($Directory);
    $Regex = new RegexIterator(
        $Iterator,
        '/^.+\.(mp4|jpeg|jpg|gif|webp|avif|png)$/i',
        RecursiveRegexIterator::GET_MATCH
    );
    foreach ($Regex as $r) {
        $f = str_replace("/home/ax/MyAndroid/", "/var/www/vids/temp/", $r[0]);
        @mkdir(dirname($f), 0777, true);
        echo "$r[0] > $f ";
        if (!file_exists($f) or filesize($r[0]) > filesize($f)) {
            copy($r[0], $f);
        }
        if (filesize($r[0]) == filesize($f)) {
            unlink($r[0]);
            echo " Moved!\n";
        }
        	else
        {
        	echo " Failed!";
        }

        sleep(1);
    }
}
function __destruct()
{
    shell_exec("fusermount -u /home/ax/MyAndroid");
    shell_exec("go-mtpfs /home/ax/MyAndroid");
    shell_exec("php /home/ax/androscanner.php");
}

scanr();
