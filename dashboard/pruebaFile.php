<?php
function find_filesize($file)
{

    if(substr(PHP_OS, 0, 3) == "WIN")
    {
        exec('for %I in ("'.$file.'") do @echo %~zI', $output);
        $return = $output[0];
    }
    else
    {
        $return = filesize($file);
    }
    return $return;
}

//Usage : find_filesize("path");
//Example : D:\wamp\www\ssaifdesarrollo.git\trunk\dashboard\imagenes
echo "File size is : ".find_filesize("imagenes/dash_logo3.png")."";


?>
