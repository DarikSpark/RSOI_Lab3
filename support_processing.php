<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Обработка данных системы поддержки решений</title>
<meta name="generator" content="BMSTU">

</head>
<body>



<?php
// Сделать проверку заполнения с помощью JavaScript на предыдущем шаге

if (isset($_POST['warehouses'])) {$warehouses = $_POST['warehouses']; if ($warehouses == '') {unset($warehouses);} };
if (isset($_POST['countSort'])) {$countSort = $_POST['countSort']; if ($countSort == '') {unset($countSort);} };

for($i=1; $i < $countSort; $i++)
    {
      if (isset($_POST[$i])) {$sortVal[$i] = $_POST[$i];}
    };

 
	$countCheckedSort = 0;
 	for($i=1; $i <= $countSort; $i++)
    { 
		if($sortVal[$i] != "")
 	 	{
		 $countCheckedSort++;
		 $checkedSortID[$countCheckedSort] = $i;
   		};
 	};
      
#	echo("Вы выбрали $countCheckedSort сорт(ов): ");
 	
	for($i=1; $i <= $countCheckedSort; $i++)
    { 
		#echo 'Сорт '.$checkedSortID[$i].' = '.$sortVal[$checkedSortID[$i]] . '; ';
 	};


$tmp = 25;

echo '<script type="text/javascript">';
echo "var arra = '".json_encode($checkedSortID)."';";
#echo 'alert(arra);';
echo '</script>';

?>

<script type="application/javascript">alert(arra)</script>


<?php
echo '<br>';

  if(empty($warehouses))
  {
    echo("Вы ничего не выбрали.");
  }
  else
  {
    $countWh = count($warehouses);
#    echo("Вы выбрали $countWh склад(ов): ");
    for($i=0; $i < $countWh; $i++)
    {
#      echo($warehouses[$i] . "; ");
    }
  }
  
 // Проверка выбрано ли определенное значение  if(IsChecked('warehouse','2')) {};
  function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
	

	



$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

for ($whID = 1; $whID <= $countWh; $whID++)
{
	 if(IsChecked('warehouses',$whID))
	 {
		 for ($i=1; $i <= $countCheckedSort; $i++)
		    { 
				$result = mysql_query("SELECT count, cost, date FROM whsort WHERE whID='$whID' AND 
				whsortID='$checkedSortID[$i]' ");
				$row = mysql_fetch_array($result);
                $whSortData[$checkedSortID[$i]][$whID]['count'] = $row['count'];
                $whSortData[$checkedSortID[$i]][$whID]['cost'] = $row['cost'];
                $whSortData[$checkedSortID[$i]][$whID]['date'] = $row['date'];
				  while($row = mysql_fetch_array($result))
				  {
		  	  			if ($row['date'] > $whSortData['whID'][$checkedSortID[$i]]['date'])
						{
							$whSortData[$checkedSortID[$i]][$whID]['count'] = $row['count'];
							$whSortData[$checkedSortID[$i]][$whID]['cost'] = $row['cost'];
							$whSortData[$checkedSortID[$i]][$whID]['date'] = $row['date'];
						};
				  };
				
		 		
			};
	 };
};

#echo '<br>'.$whSortData[3][2]['count'].' '.$whSortData[2][3]['cost'].' '.$whSortData[2][3]['date'];

/*
$result = mysql_query("SELECT `date` ,  `count` ,  `cost`
FROM  `whsort` 
WHERE  `whsortID` = 3
AND  `whID` = 2 ");
				$row = mysql_fetch_array($result);
				$whSortData[2][3]['count'] = $row['count'];
				$whSortData[2][3]['cost'] = $row['cost'];
				$whSortData[2][3]['date'] = $row['date'];
				echo $whSortData[2][3]['count'];
*/
/*
// Добавляем сорт
if (isset($sort) && isset($plantation) && isset($length))
{
$result = mysql_query("INSERT INTO sort (sort, plantation, length) 
VALUES ('$sort', '$plantation', $length)");

$sortID = mysql_insert_id($db);
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по сорту";
	exit;
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
/*}

// Добавляем заказ
if (isset($sortID) && isset($count))
{
$result = mysql_query("INSERT INTO zakaz (sortID, count) 
VALUES ('$sortID', '$count')");

$zakazID = mysql_insert_id($db);
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по заказу ";
	exit;
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
/*}
/*
// Находим cityID
$result = mysql_query("SELECT cityID FROM city WHERE city='$city'");
$cityrow = mysql_fetch_array($result);
$cityID = $cityrow['cityID'];


// Добавляем сделку
if (isset($clientID) && isset($managerID) && isset($zakazID) && isset($cityID)
 && isset($statusBargain) && isset($budget) && isset($note))
{
$result = mysql_query("INSERT INTO bargain (clientID, managerID, zakazID, cityID, statusBargain, budget, note) 
VALUES ($clientID, $managerID, $zakazID, $cityID, '$statusBargain', $budget, '$note')");
	
	echo "<br> <br> Вы успешно добавили данные в базу данных";    
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://www.rosescrm.brottys.ru/bargain.php");
}
else
{
	echo "<br> <br>Вы ввели не полную информацию по сделке";
	
	/* Возврат на предыдущую страницу с восстановлением прежде введенных данных */
/*}
*/

?>


</body>
</html>