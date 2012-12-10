<?php
echo 'here';
try
{

        /*** a file that does not exist ***/
        $image = '/file/does/not/exists.jpg';

        /*** a new imagick object ***/
        $im = new Imagick();
echo 'here';
        echo 'Imagick';
}
catch(Exception $e)
{
        echo $e->getMessage();
}


?>
