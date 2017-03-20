<?php
/*------------------------------------------------------------
    Basic application to write data from sqlite db into a file
    Test Application created for writing matching rows with given string
 -------------------------------------------------------------*/

$dir    = '/path of file';
$dbh    = new PDO($dir) or die("cannot open the database");
$query  =  "SELECT nameid, objectname, metricname FROM names WHERE objectname like '%network%'";
$fp     = fopen('/path of file', 'w');
foreach ($dbh->query($query) as $row)
{
    if(
        //($row[1] == 'network.shmem-1.mesh' && $row[2]=='packets-in') ||
        //($row[1] == 'network.shmem-1.mesh' && $row[2]=='packets-out') ||
        ($row[1] == 'network.shmem-1.mesh' && $row[2]== 'contention-delay')
        ) {
            $name                   = $row[1].' '.$row[2]. ' ';
            fwrite($fp, $name);
            $params                 = $row[0];
            $sub_query              = "SELECT value FROM `(name of table)` WHERE nameid = $params";
            foreach($dbh->query($sub_query) as $val) {
                $val['value']       = (float)$val['value'];
                if(($row[1] == 'network.shmem-1.mesh' && $row[2]== 'contention-delay')) {
                    $val['value']   = $val['value']/1000000; 
                }
                fwrite($fp, $val['value']);
                fwrite($fp, ' ');
            }
            fwrite($fp, "\n");
        }
    }
fclose($fp);
?>