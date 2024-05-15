<?php

$line = "=========================================================\n";
$dir = getcwd();

// Project folder
$source = "src/";

echo "$line$dir\n$line\n\n";

if (file_exists($source)) {
    chdir('public');
    $dir = getcwd();
    if (file_exists($source)) {
        echo "$line$dir\n$line---->";
        throw new Exception("Sudah dalam mode development");
    }
    echo "$line$dir\n$line---->";
    if (!shell_exec('mklink /D src ..\src')) {
        throw new Exception("ada kesalahan");
    }
    chdir('../src');
    copy("index.php", "../app/Views/Panel/Layout/Panel/index.php");
    echo "Berhasil masuk ke mode development";
    exit;
} else {
    throw new Exception("Folder source project tidak dikenali");
}