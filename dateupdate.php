<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Установка дат</title>
</head>

<?php

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

# Извлечение значений MySQL методами
/*
#
$result = mysql_query('
SELECT bargainID, bargdate 
FROM bargain
ORDER BY bargdate Desc
LIMIT 1
');

$pre = mysql_fetch_array($result);
$preID = $pre['bargainID'];
$predate = $pre['bargdate'];
echo 'Предыдущая дата :'.$predate."<br>";
echo 'Предыдущая дата :'.$preID."<br>";

$result = mysql_query('
SELECT bargainID, bargdate 
FROM bargain
ORDER BY bargdate DESC
LIMIT 2
');
*/

$result = mysql_query("
SELECT bargainID, bargdate 
FROM bargain
");


$i = 1;
$ii = 1;
$pre = mysql_fetch_array($result);
while ($act = mysql_fetch_array($result))
{
    mysql_query("
    UPDATE `bargain` SET `bargdate` := DATE_ADD(\"".$pre[bargdate]."\", INTERVAL $i DAY) WHERE bargainID = $act[bargainID];");
    $ii++;
    if ($ii%4==0 || $ii%3==0) {$i++;};

}

# Увеличение спроса в праздничные дни
mysql_query("
    UPDATE `bargain` SET `budget` := budget *1 WHERE DAYOFYEAR(bargdate) = DAYOFYEAR('1998-03-08')");
mysql_query("
    UPDATE `bargain` SET `budget` := budget * 1 WHERE DAYOFYEAR(bargdate) = DAYOFYEAR('1998-02-14')");
mysql_query("
    UPDATE `bargain` SET `budget` := budget *1 WHERE DAYOFYEAR(bargdate) = DAYOFYEAR('1998-09-01')");
mysql_query("
    UPDATE `bargain` SET `budget` := budget *1 WHERE DAYOFYEAR(bargdate) = DAYOFYEAR('1998-05-25')");

# Поправка периодов спада и возрастания
mysql_query("
    UPDATE `bargain` SET `budget` := budget *1 WHERE DAYOFYEAR( bargdate ) > DAYOFYEAR(  '1998-03-01' )
AND DAYOFYEAR( bargdate ) < DAYOFYEAR(  '1998-06-15' ) ");
mysql_query("
    UPDATE `bargain` SET `budget` := budget *1 WHERE DAYOFYEAR( bargdate ) > DAYOFYEAR(  '1998-10-01' )
AND DAYOFYEAR( bargdate ) < DAYOFYEAR(  '1998-12-15' ) ");

# В итоге: В праздники спрос увеличивается приблизительно в 10 - 5 раз, весной увеличение спроса в 2 раза, осенью уменьшение в 2 раза

/*
$preID = $pre['bargainID'];
$predate = $pre['bargdate'];
echo 'Предыдущая дата :'.$predate."<br>";
echo 'Предыдущая дата :'.$preID."<br>";

$act = mysql_fetch_array($result);
$act = mysql_fetch_array($result);
$actID = $act['bargainID'];
$actdate = $act['bargdate'];

echo 'Текущая дата :'.$actdate."<br>";
echo 'Текущая дата :'.$actID."<br>";
*/
/*
$result = mysql_query("
UPDATE `bargain` SET `bargdate` := DATE_ADD(\"".$actdate."\", INTERVAL 1 DAY) WHERE bargainID = 6;
");
*/

?>

<body>
</body>
</html>