--TEST--
Check for #14
--FILE--
<?php
$loop = uv_default_loop();
$filename ="does_not_exist.txt";
uv_fs_stat($loop, $filename, function ($result, $stat) {
    if (!$result) {
        echo  'OK' . PHP_EOL;
    } else {
        echo 'FAILED: uv_fs_stat should have returned false' . PHP_EOL;
    }

    if (is_null($stat)) {
        echo "NULL" . PHP_EOL;
    } else {
        echo "FAILED: uv_fs_stat \$stat return value should be NULL" . PHP_EOL;
    }
});

$filename = tempnam(sys_get_temp_dir(), 'test-no14');

uv_fs_stat($loop, $filename, function ($result, $stat) {
    if (is_resource($result)) {
        echo 'OK' . PHP_EOL;
    } else {
        echo "FAILED: uv_fs_stat should have returned a resource of type stream" . PHP_EOL;
    }

    if(!empty($stat)) {
        echo 'OK' . PHP_EOL;
    } else {
        echo 'FAILED: $stat should be an array with values' . PHP_EOL;
    }
});

uv_run();

--EXPECT--
OK
NULL
OK
OK
