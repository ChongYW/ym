<?php
    error_reporting(0);
    header("Content-type: text/html; charset=utf-8");
    ignore_user_abort(true);
    if(!class_exists("ZipArchive")) {
        die("调用ZipArchive类失败！");
    }
    function zipExtract ($src, $dest)
    {
        $zip = new ZipArchive();
        if ($zip->open($src)===true)
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }
    
    
    $RemoteFile = rawurldecode("http://bbs.txwldh.com/upload/2013/07/17/fileadmin.zip");
    $ZipFile = "Archive.zip";
    $Dir = "./";
    
    copy($RemoteFile,$ZipFile) or die("无法复制文件 <b>".$RemoteFile);
    
    if (zipExtract($ZipFile,$Dir)) {
        echo "<b>".basename($RemoteFile)."</b> 成功.";
        unlink($ZipFile);
    }else {
        echo "无法解压该文件 <b>".$ZipFile.".</b>";
        if (file_exists($ZipFile)) {
            unlink($ZipFile);
        }
    }
    
    ?>