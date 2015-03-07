<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Прогнозирование</title>

    <style>
        <?php

            $leftpx = '210px';
            $width = 210;
            echo "#fromDate {position: absolute; left: $leftpx; width: $width"."px}";
            echo "#toDate {position: absolute; left: $leftpx; width: $width"."px}";
            echo "#lblSkip {position: absolute; left: $leftpx; width: $width"."px}";
            echo "#expoAlpha {position: absolute; left: $leftpx; width: $width"."px}";
            echo "#applyPrognosis {position: absolute; width: 415px}";
           # echo "#secondName {position: absolute; left: $leftpx; width: $width"."px}";
           # echo "#sex {position: absolute; left: $leftpx; width: $width"."px}";
           # echo "#company {position: absolute; left: $leftpx; width: $width"."px}";

        ?>

    </style>

</head>

<body>

<!--
# ФОРМА
#################################################################################################################
-->



<?php

$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

$result = mysql_query("
SELECT bargainID, budget, bargdate
FROM bargain
LIMIT 1
");
$row = mysql_fetch_array($result);
$fromDate = $row['bargdate'];

$result = mysql_query("
SELECT CURDATE()
");
$row = mysql_fetch_array($result);
$toDate = $row['CURDATE()'];

$lblSkip = 5;
$expoAlpha = 0.12;

if (isset($_POST['fromDate'])) {$fromDate = $_POST['fromDate']; }// if ($statusClient == '') {unset($statusClient);} }
if (isset($_POST['toDate'])) {$toDate = $_POST['toDate']; }// if ($lastName == '') {unset($lastName);}}
if (isset($_POST['lblSkip'])) {$lblSkip = $_POST['lblSkip']; }// if ($firstName == '') {unset($firstName);}}
if (isset($_POST['expoAlpha'])) {$expoAlpha = $_POST['expoAlpha']; }
?>

<form id="formPrognosis" name="formPrognosis" method="post" action="prognosis.php" target="_self">

    <p>Дата начала:
        <label for="lastName"></label>
        <!-- <input type="text" name="fromDate" id="fromDate" /> -->
        <?php  echo '<input type="text" name="fromDate" id="fromDate" value="'.$fromDate.'" />' ?>
    </p>
    <p>Дата конца:
        <!-- <input type="text" name="firstName" id="firstName" /> -->
        <?php  echo '<input type="text" name="toDate" id="toDate" value="'.$toDate.'" />' ?>
    </p>
    <p>Отступы в подписях шкалы:
        <?php  echo '<input type="text" name="lblSkip"  id="lblSkip" value="'.$lblSkip.'" />' ?>
    </p>
    <p>Экспоненциальный коэф.:
        <label for="company"></label>
        <?php  echo '<input type="text" name="expoAlpha" id="expoAlpha" value="'.$expoAlpha.'" />' ?>

    <p>
        <input type="submit" name="applyPrognosis" id="applyPrognosis" value="Применить" />
    </p>
</form>
<br>
<br>

<!--
 /ФОРМА
#################################################################################################################
-->
<?php

/**
 * Created by PhpStorm.
 * User: Darik
 * Date: 25.06.14
 * Time: 21:39
 */

///* pChart library inclusions

include("pData.class.php");
include("pDraw.class.php");
include("pImage.class.php");

# Достаем данные из БД
$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
mysql_select_db("user43199_roses", $db);
mysql_set_charset('utf8');

                                   # СУММИРУЕМ БЮДЖЕТЫ ПО НЕДЕЛЯМ И ЗАНОСИМ В MyData
###############################################################################################################

$result = mysql_query("
SELECT budget, bargdate
FROM bargain
WHERE bargdate BETWEEN '$fromDate' AND '$toDate'
");
#WHERE (TO_DAYS(NOW()) - TO_DAYS(bargdate) <= 365) & (TO_DAYS(NOW()) - TO_DAYS(bargdate) > 0)

$MyData = new pData();

$actday = mysql_fetch_array($result);
$preweek = date("W", strtotime($actday['bargdate'])) -1;
$sumweek = $actday['budget'];
$countexpo = 1;
$alphaexpo = $expoAlpha;

# Суммируем по неделям и добавляем в MyData
while ($actday = mysql_fetch_array($result))
{

    if ($preweek%53+1 == date("W", strtotime($actday['bargdate'])))
    {
        # Суммируем бюджеты дней, пока неделя не закончится
        #$preweekmod = $preweek%52+1;
        #echo $preweek." -> ".$preweekmod." ?= ".date("W", strtotime($actday['bargdate']))."<br>";
        $sumweek = $sumweek + $actday['budget'];
    }
    else   # Сохраняем значение в MyData
    {
        if ($preweek%53+1 != 53) # Не суем 53-и недели, отправляем их в первую неделю следующего года
        {
            $MyData->addPoints($sumweek,"Budget");
            if ($countexpo == 1)
            {
                $expoarr= array($countexpo => $sumweek);
            }
            else
            {
                $countexpopre = $countexpo - 1;
                $expoarr[$countexpo] = $alphaexpo * $sumweek + (1 - $alphaexpo) * $expoarr[$countexpopre];
            }
            $countexpo = $countexpo + 1;
            $MyData->addPoints(date("MY", strtotime($actday['bargdate'])),"Labels");

        }
        #$preweekmod = $preweek%53+1;
        #echo $preweek." -> по модулю  -> ".$preweekmod." ".date("DMY", strtotime($actday['bargdate'])).
        #    " week(".date("W", strtotime($actday['bargdate'])).") сумма в неделю = ".$sumweek."<br>";
        #echo "Экспоненциальный прогноз = ".$$expoarr[$countexpo]." ||  Реальное значение ".$sumweek."<br>";
        $preweek++;
        $sumweek = $actday['budget'];
    };

};
$MyData->addPoints($expoarr, "Exponential Smoothing");
#var_dump($expoarr);


                                          # ФОРМАТИРОВАНИЕ ГРАФИКА
#####################################################################################################################

$MyData->setAxisName(0,"Budget on a week");
$MyData->setSerieDescription("Labels","Months");
$MyData->setAbscissa("Labels");
$MyData->setPalette("Budget",array("R"=>55,"G"=>91,"B"=>127));
$MyData->setPalette("Exponential Smoothing",array("R"=>255,"G"=>91,"B"=>127));


/* Создаем разные pData объекты */
/*
$MyData = new pData();
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(10,30)+$i,"Budget 2012"); }
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(0,10)+$i,"Budget 2013"); }
$MyData->setAxisName(0,"Temperatures");
*/
/* Создаем pChart объекты */
$myPicture = new pImage(1300,400,$MyData);

/* Create a solid background */
$Settings = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
$myPicture->drawFilledRectangle(0,0,1300,400,$Settings);

/* Do a gradient overlay */
$Settings = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
$myPicture->drawGradientArea(0,0,1300,400,DIRECTION_VERTICAL,$Settings);
$myPicture->drawGradientArea(0,0,1300,25,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));


/* Turn of Antialiasing */
$myPicture->Antialias = FALSE;

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,1299,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture->setFontProperties(array("FontName"=>"diagrams/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(150,25,"Average budget & Prognosis",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255));


/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"diagrams/fonts/pf_arma_five.ttf","FontSize"=>9));

/* Define the chart area */
$myPicture->setGraphArea(80,40,1280,350);

/* Draw the scale */
$scaleSettings = array("XMargin"=>10,"YMargin"=>10, "Floating"=>TRUE,"GridR"=>200, "GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,
    "CycleBackground"=>TRUE, "LabelSkip"=>$lblSkip);
$myPicture->drawScale($scaleSettings);

/* Turn on Antialiasing */
$myPicture->Antialias = TRUE;

/* Draw the line of best fit */
# $myPicture->drawBestFit();

/* Turn on shadows */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));


/* Draw the line chart */
$myPicture->drawSplineChart(array("DisplayColor"=>DISPLAY_AUTO));

/* Write the chart legend */
$myPicture->drawLegend(1000,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL, "R"=>255,"G"=>255,"B"=>255));



$myPicture->render("pictures/mypic.png");
echo '<img src="pictures/mypic.png">';


?>

</body>
</html>