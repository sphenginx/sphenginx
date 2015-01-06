<?php
/**
 *  Name: find file
 *  Example:
 *      php find.php d:/photo .jpg,.gif,.png "gm convert -resize 100X100 $filename $filename"
 *      php find.php .txt,.doc "copy $filename e:/document"
 */
 
// create bat file? 1:yes, 0:no
define('CREATE_BAT_FILE', 0);
 
switch(count($argv)) {
    case 4:
        $command = $argv[3];
        $match = $argv[2];
        $dir = $argv[1];
        break;
    case 3:
        $command = $argv[2];
        $match   = $argv[1];
        $dir     = __DIR__;
        break;
    default:
        exit('Error: Missing parameters!' . PHP_EOL . 
            'Example: path match command, d:/dir .jpg,.gif "echo $name"' . PHP_EOL);
}

if(!is_dir($dir)) {
    exit($dir . ' not a directory.' . PHP_EOL);
}

$directory = array(str_replace('\\', '/', $dir));
$files = array();
$index = 0;
$count = 0;
$result = '';
 
while($currentPath = current($directory)) 
{
    $dirHandle = dir($currentPath);
    while(false !== ($name = $dirHandle->read())) {
         
        if($currentPath[strlen($currentPath) - 1] == '/') {
            $filename = $currentPath . $name;
        } else {
            $filename = $currentPath . '/' . $name;
        }
 
        if($name == '..' || $name == '.') {
            continue;
        }
        if(is_dir($filename)) {
            $directory[] = $filename;
        } else {
            str_replace(explode(',', $match), '', $name, $count);
            if($match != '*' && $count == 0) {
                continue;
            }
            $template = array('$name', '$filename', '$path', '$index');
            $variable = array($name, $filename, $currentPath, $index);
            $cmd = str_replace($template, $variable, $command);
            if(CREATE_BAT_FILE) {
                $result .= $cmd . PHP_EOL;
            } else {
                echo shell_exec($cmd);
            }
            $index++;
        }
    }
 
    next($directory);
}
 
// create bat file
if(CREATE_BAT_FILE) {
    $batFile = fopen('temp.bat', 'w');
    fwrite($batFile, $result);
    fclose($batFile);
    echo 'output file to: ' . str_replace('\\', '/', __DIR__) . '/temp.bat' . PHP_EOL;
}
 
// echo result:
echo $index . ' file find.' . PHP_EOL;