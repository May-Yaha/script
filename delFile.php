<?php
/**
 * Created by PhpStorm.
 * User: yaha
 * Date: 17-11-6
 * Time: 下午11:32
 */


//遍历一层目录  (统计有多少个文件
function listdir($dirname)
{
    $ds = opendir($dirname);
    while ($file = readdir($ds)) {
        if (is_dir($file)) {
            if ($file != "." && $file != "..") {
                listdir($file);
            }
        }
    }
}

//统计目录下所有文件的容量
function totdir($dirname)
{ //对listdir稍加修改
    static $tot = 0;
    $ds = opendir($dirname);
    while ($file = readdir($ds)) {
        $path = $dirname . '/' . $file;
        if (is_dir($file)) {
            if ($file != "." && $file != "..") {
                $tot += totdir($file);
            }
        } else {
            $tot += filesize($path);
        }
    }
    return $tot;
}

//删除文件
function deldir($dirname)
{
    //删除目录下的文件：
    $dh = opendir($dirname);

    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dirname . "/" . $file;

            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    echo "delete file sesssus!";
}

$dirname = "data";
listdir($dirname);

if (totdir($dirname) >= 10240000) {
    deldir($dirname);
} else {
    echo "当前" . $dirname . "大小为：" . round(totdir($dirname) / 1048576, 2) . "MB";
}
