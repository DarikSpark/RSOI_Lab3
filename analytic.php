<?php
include("blocks/lock.php");
?>


<?php
ULogin(1);
HeadCss('Аналитика', '<link href="resource/bootstrap/dist/css/bootstrap.css" rel="stylesheet">') ?>

<?php

$leftpx = '335px';
$width = 210;
echo '<style>';
echo "#fromDate {position: absolute; left: $leftpx; width: $width"."px}";
echo "#toDate {position: absolute; left: $leftpx; width: $width"."px}";
echo "#lblSkip {position: absolute; left: $leftpx; width: $width"."px}";
echo "#expoAlpha {position: absolute; left: $leftpx; width: $width"."px}";
echo "#applyPrognosis {position: absolute; width: 415px}";
echo "#expoBetta {position: absolute; left: $leftpx; width: $width"."px}";
echo "#expoGamma {position: absolute; left: $leftpx; width: $width"."px}";
# echo "#company {position: absolute; left: $leftpx; width: $width"."px}";
echo '</style>';

?>

<body>
<div class="wrapper">
<?php HeaderLink(); ?>
<div class="content">
<?php Menu();
MessageShow()
?>

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

$lblSkip = 14;
$expoAlpha = 0.52;
$expoBetta = 0.3;
$expoGamma = 0.3;

if (isset($_POST['fromDate'])) {$fromDate = $_POST['fromDate']; }// if ($statusClient == '') {unset($statusClient);} }
if (isset($_POST['toDate'])) {$toDate = $_POST['toDate']; }// if ($lastName == '') {unset($lastName);}}
if (isset($_POST['lblSkip'])) {$lblSkip = $_POST['lblSkip']; }// if ($firstName == '') {unset($firstName);}}
if (isset($_POST['expoAlpha'])) {$expoAlpha = $_POST['expoAlpha']; }
if (isset($_POST['expoBetta'])) {$expoBetta = $_POST['expoBetta']; }
if (isset($_POST['expoGamma'])) {$expoGamma = $_POST['expoGamma']; }
?>
<br>
<form id="formPrognosis" name="formPrognosis" method="post" action="analytic.php" target="_self">

    <p>Дата начала:
        <label for="lastName"></label>
        <!-- <input type="text" name="fromDate" id="fromDate" /> -->
        <?php  echo '<input type="text" name="fromDate" id="fromDate" style="position: absolute; "/>';// value="'.$fromDate.'" />' ?>
    </p>
    <p>Дата конца:
        <!-- <input type="text" name="firstName" id="firstName" /> -->
        <?php  echo '<input type="text" name="toDate" id="toDate" value="'.$toDate.'" />' ?>
    </p>
    <p>Отступы в подписях шкалы:
        <?php  echo '<input type="text" name="lblSkip"  id="lblSkip" value="'.$lblSkip.'" />' ?>
    </p>
    <p>Экспоненциальный коэф. A:
        <label for="company"></label>
        <?php  echo '<input type="text" name="expoAlpha" id="expoAlpha" value="'.$expoAlpha.'" />' ?>
    <p>
    <p>Экспоненциальный коэф. B:
        <label for="company"></label>
        <?php  echo '<input type="text" name="expoBetta" id="expoBetta" value="'.$expoBetta.'" />' ?>
    <p>
    <p>Экспоненциальный коэф. C:
        <label for="company"></label>
        <?php  echo '<input type="text" name="expoGamma" id="expoGamma" value="'.$expoGamma.'" />' ?>
    <p>
        <input type="submit" name="applyPrognosis" id="applyPrognosis" value="Применить" />
    </p>
</form>

<br><br>


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


#WHERE (TO_DAYS(NOW()) - TO_DAYS(bargdate) <= 365) & (TO_DAYS(NOW()) - TO_DAYS(bargdate) > 0)

$MyData = new pData();
$MyData2 = new pData();
$MyData3 = new pData();
$MyEperiment = new pData();


$alphaexpo = $expoAlpha;
$bettaexpo = $expoBetta;
$gammaexpo = $expoGamma;


$months = array();


                # Суммируем по неделям и добавляем в MyData


                $result = mysql_query("
                SELECT budget, bargdate
                FROM bargain
                WHERE bargdate BETWEEN '$fromDate' AND '$toDate'
                ");

            $actday = mysql_fetch_array($result);
            $preweek = date("W", strtotime($actday['bargdate'])) -1;
            $sumweek = $actday['budget'];
            $countexpo = 1;

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
                            #$MyData->addPoints($sumweek,"Budget");

                            #echo "$countexpo = $sumweek <br>";
                            if ($countexpo == 1)
                            {
                                $realarr = array($countexpo => $sumweek);

                                # Метод экспоненциального сглаживания устанавливаем начальные значения
                                $expoarr= array($countexpo => $sumweek);

                                # Метод Хольта устанавливаем начальные значения
                                $eholt = array ($countexpo => $sumweek);
                                $tholt = array($countexpo => 0);
                                $holtexpoarr = array($countexpo => $eholt[$countexpo] + $tholt[$countexpo]);

                            }
                            else
                            {

                                $realarr[$countexpo] = $sumweek;

                                # Метод экспоненциального сглаживания
                                $countexpopre = $countexpo - 1;
                                $expoarr[$countexpo] = $alphaexpo * $sumweek + (1 - $alphaexpo) * $expoarr[$countexpopre];

                                # Метод Хольта
                                $eholt[$countexpo] = $alphaexpo * $sumweek + (1 - $alphaexpo) * ($eholt[$countexpopre] + $tholt[$countexpopre]);
                                $tholt[$countexpo] = $bettaexpo * ($eholt[$countexpo] - $eholt[$countexpopre]) + (1 - $bettaexpo) * $tholt[$countexpopre];
                                $holtexpoarr[$countexpo] = $eholt[$countexpopre] + $tholt[$countexpopre];


                            }

                            $months[$countexpo] = date("MY", strtotime($actday['bargdate']));
                            $countexpo = $countexpo + 1;


                        }
                        #$preweekmod = $preweek%53+1;
                        #echo $preweek." -> по модулю  -> ".$preweekmod." ".date("DMY", strtotime($actday['bargdate'])).
                        #    " week(".date("W", strtotime($actday['bargdate'])).") сумма в неделю = ".$sumweek."<br>";
                        #echo "Экспоненциальный прогноз = ".$$expoarr[$countexpo]." ||  Реальное значение ".$sumweek."<br>";
                        $preweek++;
                        $sumweek = $actday['budget'];
                    };

                };

####################################################################################
# Метод Хольта-Винтерса

$numweek = 1;
$season = 52;
$ySum1s = 0;
$ySum2s = 0;
while ($numweek <= 2 * $season)
{
    # Устанавливаем начальные значения
    if ($numweek <= $season)    {$ySum1s = $ySum1s + $realarr[$numweek];};
    # Устанавливаем начальные значения
    if ($numweek >= $season)    {$ySum2s = $ySum2s + $realarr[$numweek];};
    $numweek = $numweek + 1;

};
#echo "sumS = $ySum1s, Sum2S = $ySum2s ";

# Задаем начальные значения
$numweek = 3;
$eholtwinters = array ($numweek => $realarr[$numweek]);
$tholtwinters = array($numweek => 0);
$choltwinters = array($numweek => 1);
$holtwintersexpoarr = array($numweek => ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1]);
$numweek = $numweek + 1;
while ($numweek < $season)
{
    #$eholtwinters[$numweek] = $ySum1s / $season;
    #$tholtwinters[$numweek] = ($ySum1s / $season - $ySum2s / $season) / $season;
    #$choltwinters[$numweek] = ($realarr[$numweek] - ($numweek - 1) * $tholtwinters[$numweek] / 2) / $eholtwinters[$numweek];
    $eholtwinters[$numweek] = $realarr[$numweek];
    $tholtwinters[$numweek] = 0;
    $choltwinters[$numweek] = 1;
    $holtwintersexpoarr[$numweek] = ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1];
    $numweek = $numweek + 1;
}
# Делаем прогноз
#settype($otklon, double);
#$otklon2 = 0.0;
#settype($otklonsum, double);
#$otklonsum = 0.0;
while ($numweek <= $countexpo)
{
    $eholtwinters[$numweek] = $alphaexpo * $realarr[$numweek - 1] / $choltwinters[$numweek - $season] + (1 - $alphaexpo) * ($eholtwinters[$numweek - 1] + $tholtwinters[$numweek - 1]);
    $tholtwinters[$numweek] = $bettaexpo * ($eholtwinters[$numweek] - $eholtwinters[$numweek - 1]) + (1 - $bettaexpo) * $tholtwinters[$numweek - 1];
    $choltwinters[$numweek] = $gammaexpo * $realarr[$numweek - 1] / $eholtwinters[$numweek - 1] + (1 - $gammaexpo) * $choltwinters[$numweek - $season];
    $holtwintersexpoarr[$numweek] = ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1];
    $numweek = $numweek + 1;
};


$holtwintersarrform = array();
$holtwintersarrform = $holtwintersexpoarr;


#Сравним результаты при одних и тех же коэффициентах
$numweek = 1;
$otklonhw = 0.0;
while ($numweek <= $countexpo)
{

    # считаем отклонение прогнозов через два года
    #if ($numweek >= 2 * $season)
    #{
    $otklones = pow(($realarr[$numweek] - $expoarr[$numweek]), 2) / pow($realarr[$numweek], 2);
    $otklonh = pow(($realarr[$numweek] - $holtexpoarr[$numweek]), 2) / pow($realarr[$numweek], 2);
    $otklonhw = pow(($realarr[$numweek] - $holtwintersexpoarr[$numweek]), 2) / pow($realarr[$numweek], 2);

    $otklonsumes = $otklonsumes + $otklones;
    $otklonsumh = $otklonsumh + $otklonh;
    $otklonsumhw = $otklonsumhw + $otklonhw;

    $mides = $otklones / $countexpo;
    $midh = $otklonh / $countexpo;
    $midhw = $otklonhw / $countexpo;

    $precises = 1 - $mides;
    $precish = 1 - $midh;
    $precishw = 1 - $midhw;


    #var_dump($otklon2); echo "<br>";
    # echo "альфа тек = $alphaexpo; бетта тек = $bettaexpo; гамма тек = $gammaexpo; Отклон сум = $otklonsum; Отклон $otklon2; Numweek = $numweek; <br>";
    $numweek = $numweek + 1;
    #}
};


######################################## ПРОВОДИМ ТЕСТИРОВАНИЕ И ВЫЯВЛЕНИЯ ОПТИМАЛЬНЫХ КОЭФФИЦИЕНТОВ
###################################################################

$alphaexpo = 0.01;
$bettaexpo = 0.01;
$gammaexpo = 0.01;
$alphaexpofinal = 0.0;
$bettaexpofinal = 0.0;
$gammaexpofinal = 0.0;
$otklonsumfinal = 9999999999.0;
$holtwintersexpoarrmin = array();
while ($alphaexpo < 1)
{
    while ($bettaexpo < 1)
    {
        while ($gammaexpo < 1)
        {
                # Метод Хольта-Винтерса
                $numweek = 0;
                $season = 52;
                $ySum1s = 0;
                $ySum2s = 0;
                while ($numweek <= 2 * $season)
                {
                    # Устанавливаем начальные значения
                    if ($numweek <= $season)    {$ySum1s = $ySum1s + $realarr[$numweek];};
                    # Устанавливаем начальные значения
                    if ($numweek >= $season)    {$ySum2s = $ySum2s + $realarr[$numweek];};
                    $numweek = $numweek + 1;

                };
                #echo "sumS = $ySum1s, Sum2S = $ySum2s ";

                # Задаем начальные значения
                $numweek = 3;
                $eholtwinters = array ($numweek => $realarr[$numweek]);
                $tholtwinters = array($numweek => 0);
                $choltwinters = array($numweek => 1);
                $holtwintersexpoarr = array($numweek => ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1]);
                $numweek = $numweek + 1;
                while ($numweek < $season)
                {
                    #$eholtwinters[$numweek] = $ySum1s / $season;
                    #$tholtwinters[$numweek] = ($ySum1s / $season - $ySum2s / $season) / $season;
                    #$choltwinters[$numweek] = ($realarr[$numweek] - ($numweek - 1) * $tholtwinters[$numweek] / 2) / $eholtwinters[$numweek];
                    $eholtwinters[$numweek] = $realarr[$numweek];
                    $tholtwinters[$numweek] = 0;
                    $choltwinters[$numweek] = 1;
                    $holtwintersexpoarr[$numweek] = ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1];
                    $numweek = $numweek + 1;
                }


                # Делаем прогноз
            #settype($otklon, double);
            $otklon2 = 0.0;
            #settype($otklonsum, double);
            $otklonsum = 0.0;
                while ($numweek <= $countexpo)
                {
                    $eholtwinters[$numweek] = $alphaexpo * $realarr[$numweek - 1] / $choltwinters[$numweek - $season] + (1 - $alphaexpo) * ($eholtwinters[$numweek - 1] + $tholtwinters[$numweek - 1]);
                    $tholtwinters[$numweek] = $bettaexpo * ($eholtwinters[$numweek] - $eholtwinters[$numweek - 1]) + (1 - $bettaexpo) * $tholtwinters[$numweek - 1];
                    $choltwinters[$numweek] = $gammaexpo * $realarr[$numweek - 1] / $eholtwinters[$numweek - 1] + (1 - $gammaexpo) * $choltwinters[$numweek - $season];
                    $holtwintersexpoarr[$numweek] = ($eholtwinters[$numweek] + $tholtwinters[$numweek]) / $choltwinters[$numweek - $season + 1];

                    # считаем отклонение прогнозов через два года
                    #if ($numweek >= 2 * $season)
                    #{
                        $otklon2 = pow(($realarr[$numweek] - $holtwintersexpoarr[$numweek]), 2) / pow($realarr[$numweek], 2) + 0.00000001;

                        $otklonsum = 0.000001 + $otklonsum + $otklon2;
                    #var_dump($otklon2); echo "<br>";
                       # echo "альфа тек = $alphaexpo; бетта тек = $bettaexpo; гамма тек = $gammaexpo; Отклон сум = $otklonsum; Отклон $otklon2; Numweek = $numweek; <br>";
                    $numweek = $numweek + 1;
                    #}
                };


            if ($otklonsumfinal > $otklonsum)
            {
                $holtwintersexpoarrmin = $holtwintersexpoarr;
                $alphaexpofinal = $alphaexpo;
                $bettaexpofinal = $bettaexpo;
                $gammaexpofinal = $bettaexpo;
                $otklonsumfinal = $otklonsum;
                #echo "alphafinal $alphaexpofinal <br>";
            };

            $gammaexpo = $gammaexpo + 0.05;

        }

        $bettaexpo = $bettaexpo + 0.05;
        $gammaexpo = 0.01;

    }

    $alphaexpo = $alphaexpo + 0.05;
    $bettaexpo = 0.01;
    $gammaexpo = 0.01;
   # echo "Hello $alphaexpo; ";

}

$midhwexper = $otklonsumfinal / ($countexpo - $season); # среднее отклонение
$precisHWexper = 1 - $midhwexper; # точность
 # Отклонение мин = $otklonsumfinal; Отклон тек = $otklonsum;
#альфа тек = $alphaexpo; гамма тек = $gammaexpo; ";




# ФОРМАТИРОВАНИЕ ГРАФИКА
#####################################################################################################################

# Вносим данные наших графиков
$MyData->addPoints($realarr,"Budget");
$MyData->addPoints($expoarr, "Exponential Smoothing");
$MyData->addPoints($months,"Labels");


$MyData->setAxisName(0,"Budget of a week");
$MyData->setSerieDescription("Labels","Months");
$MyData->setAbscissa("Labels");
$MyData->setPalette("Budget",array("R"=>55,"G"=>91,"B"=>127));
$MyData->setPalette("Exponential Smoothing",array("R"=>255,"G"=>91,"B"=>127));

$ImageWidth = 950;


/* Создаем разные pData объекты */
/*
$MyData = new pData();
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(10,30)+$i,"Budget 2012"); }
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(0,10)+$i,"Budget 2013"); }
$MyData->setAxisName(0,"Temperatures");
*/
/* Создаем pChart объекты */
$myPicture = new pImage($ImageWidth,400,$MyData);

/* Create a solid background */
$Settings = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
$myPicture->drawFilledRectangle(0,0,$ImageWidth,400,$Settings);

/* Do a gradient overlay */
$Settings = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
$myPicture->drawGradientArea(0,0,$ImageWidth,400,DIRECTION_VERTICAL,$Settings);
$myPicture->drawGradientArea(0,0,$ImageWidth,25,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));


/* Turn of Antialiasing */
$myPicture->Antialias = FALSE;

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,$ImageWidth-1,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture->setFontProperties(array("FontName"=>"diagrams/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(150,25,"Average budget & Prognosis",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255));


/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"diagrams/fonts/pf_arma_five.ttf","FontSize"=>9));

/* Define the chart area */
$myPicture->setGraphArea(80,40,$ImageWidth-20,350);

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
$myPicture->drawLegend(400,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL, "R"=>255,"G"=>255,"B"=>255));


#echo "Точность метода при заданных коэффициентах: $precises; ср. ошибка $mides; сум отклон = $otklonsumes;";
$myPicture->render("pictures/mypic.png");
echo '<p  style="text-align: center;"><img src="pictures/mypic.png""></p>';

#### ХОЛЬТ
# Вносим данные наших графиков

$MyData2->addPoints($realarr,"Budget");
$MyData2->addPoints($holtexpoarr, "Holt Method");
$MyData2->addPoints($months,"Labels");


$MyData2->setAxisName(0,"Budget of a week");
$MyData2->setSerieDescription("Labels","Months");
$MyData2->setAbscissa("Labels");
$MyData2->setPalette("Budget",array("R"=>55,"G"=>91,"B"=>127));
$MyData2->setPalette("Holt Method",array("R"=>255,"G"=>11,"B"=>27));


/* Создаем разные pData объекты */
/*
$MyData = new pData();
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(10,30)+$i,"Budget 2012"); }
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(0,10)+$i,"Budget 2013"); }
$MyData->setAxisName(0,"Temperatures");
*/
/* Создаем pChart объекты */
$myPicture22 = new pImage($ImageWidth,400,$MyData2);

/* Create a solid background */
$Settings22 = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
$myPicture22->drawFilledRectangle(0,0,$ImageWidth,400,$Settings22);

/* Do a gradient overlay */
$Settings22 = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
$myPicture22->drawGradientArea(0,0,$ImageWidth,400,DIRECTION_VERTICAL,$Settings22);
$myPicture22->drawGradientArea(0,0,$ImageWidth,25,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));


/* Turn of Antialiasing */
$myPicture22->Antialias = FALSE;

/* Add a border to the picture */
$myPicture22->drawRectangle(0,0,$ImageWidth-1,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture22->setFontProperties(array("FontName"=>"diagrams/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture22->drawText(150,25,"Average budget & Prognosis",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255));


/* Set the default font */
$myPicture22->setFontProperties(array("FontName"=>"diagrams/fonts/pf_arma_five.ttf","FontSize"=>9));

/* Define the chart area */
$myPicture22->setGraphArea(80,40,$ImageWidth-20,350);

/* Draw the scale */
$scaleSettings22 = array("XMargin"=>10,"YMargin"=>10, "Floating"=>TRUE,"GridR"=>200, "GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,
    "CycleBackground"=>TRUE, "LabelSkip"=>$lblSkip);
$myPicture22->drawScale($scaleSettings22);

/* Turn on Antialiasing */
$myPicture22->Antialias = TRUE;

/* Draw the line of best fit */
# $myPicture->drawBestFit();

/* Turn on shadows */
$myPicture22->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));


/* Draw the line chart */
$myPicture22->drawSplineChart(array("DisplayColor"=>DISPLAY_AUTO));

/* Write the chart legend */
$myPicture22->drawLegend(400,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL, "R"=>255,"G"=>255,"B"=>255));


#echo "Точность метода при заданных коэффициентах: $precish;  ср. ошибка $midh; сум отклон = $otklonsumh;";
$myPicture22->render("pictures/mypic22.png");
echo '<p  style="text-align: center;"><img src="pictures/mypic22.png"></p>';



$MyData3->addPoints($realarr,"Budget");
$MyData3->addPoints($holtwintersarrform, "Holt-Winters Method");
$MyData3->addPoints($months,"Labels");


$MyData3->setAxisName(0,"Budget of a week");
$MyData3->setSerieDescription("Labels","Months");
$MyData3->setAbscissa("Labels");
$MyData3->setPalette("Budget",array("R"=>55,"G"=>91,"B"=>127));
$MyData3->setPalette("Holt-Winters Method",array("R"=>255,"G"=>0,"B"=>0));


/* Создаем разные pData объекты */
/*
$MyData = new pData();
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(10,30)+$i,"Budget 2012"); }
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(0,10)+$i,"Budget 2013"); }
$MyData->setAxisName(0,"Temperatures");
*/
/* Создаем pChart объекты */
$myPicture3 = new pImage($ImageWidth,400,$MyData3);

/* Create a solid background */
$Settings22 = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
$myPicture3->drawFilledRectangle(0,0,$ImageWidth,400,$Settings22);

/* Do a gradient overlay */
$Settings22 = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
$myPicture3->drawGradientArea(0,0,$ImageWidth,400,DIRECTION_VERTICAL,$Settings22);
$myPicture3->drawGradientArea(0,0,$ImageWidth,25,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));


/* Turn of Antialiasing */
$myPicture3->Antialias = FALSE;

/* Add a border to the picture */
$myPicture3->drawRectangle(0,0,$ImageWidth-1,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture3->setFontProperties(array("FontName"=>"diagrams/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture3->drawText(150,25,"Average budget & Prognosis",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255));


/* Set the default font */
$myPicture3->setFontProperties(array("FontName"=>"diagrams/fonts/pf_arma_five.ttf","FontSize"=>9));

/* Define the chart area */
$myPicture3->setGraphArea(80,40,$ImageWidth-20,350);

/* Draw the scale */
$scaleSettings22 = array("XMargin"=>10,"YMargin"=>10, "Floating"=>TRUE,"GridR"=>200, "GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,
    "CycleBackground"=>TRUE, "LabelSkip"=>$lblSkip);
$myPicture3->drawScale($scaleSettings22);

/* Turn on Antialiasing */
$myPicture3->Antialias = TRUE;

/* Draw the line of best fit */
# $myPicture->drawBestFit();

/* Turn on shadows */
$myPicture3->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));


/* Draw the line chart */
$myPicture3->drawSplineChart(array("DisplayColor"=>DISPLAY_AUTO));

/* Write the chart legend */
$myPicture3->drawLegend(400,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL, "R"=>255,"G"=>255,"B"=>255));


##echo "Точность метода при заданных коэффициентах: $precishw; ср. ошибка $midhw; сум отклон = $otklonsumhw;";
$myPicture3->render("pictures/mypic3.png");
echo '<p  style="text-align: center;"><img src="pictures/mypic3.png"></p>';



# ЭКСПЕРИМЕНТАЛЬНЫЙ РАЗДЕЛ
####################################################################################################################

echo "<br> Наиболее оптимальное решение: Альфа = $alphaexpofinal; Бетта = $bettaexpofinal; Гамма = $gammaexpofinal;"; #Точность = $precisHWexper;";

$MyEperiment->addPoints($realarr, "Budget");
$MyEperiment->addPoints($holtwintersexpoarrmin, "Holt-Winters Method (Optimal coefficients)");
$MyEperiment->addPoints($months,"Labels");

$MyEperiment->setAxisName(0,"Budget of a week");
$MyEperiment->setSerieDescription("Labels","Months");
$MyEperiment->setAbscissa("Labels");
$MyEperiment->setPalette("Budget",array("R"=>55,"G"=>91,"B"=>127));
$MyEperiment->setPalette("Exponential Smoothing",array("R"=>255,"G"=>91,"B"=>127));


/* Создаем разные pData объекты */
/*
$MyData = new pData();
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(10,30)+$i,"Budget 2012"); }
for($i=0;$i<=20;$i++) { $MyData->addPoints(rand(0,10)+$i,"Budget 2013"); }
$MyData->setAxisName(0,"Temperatures");
*/
/* Создаем pChart объекты */
$myPicture2 = new pImage($ImageWidth,400,$MyEperiment);

/* Create a solid background */
$Settings2 = array("R"=>179, "G"=>217, "B"=>91, "Dash"=>1, "DashR"=>199, "DashG"=>237, "DashB"=>111);
$myPicture2->drawFilledRectangle(0,0,$ImageWidth,400,$Settings2);

/* Do a gradient overlay */
$Settings2 = array("StartR"=>194, "StartG"=>231, "StartB"=>44, "EndR"=>43, "EndG"=>107, "EndB"=>58, "Alpha"=>50);
$myPicture2->drawGradientArea(0,0,$ImageWidth,400,DIRECTION_VERTICAL,$Settings2);
$myPicture2->drawGradientArea(0,0,$ImageWidth,25,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));


/* Turn of Antialiasing */
$myPicture2->Antialias = FALSE;

/* Add a border to the picture */
$myPicture2->drawRectangle(0,0,$ImageWidth-1,399,array("R"=>0,"G"=>0,"B"=>0));

/* Write the chart title */
$myPicture2->setFontProperties(array("FontName"=>"diagrams/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture2->drawText(150,25,"Searching optimal decision",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255));


/* Set the default font */
$myPicture2->setFontProperties(array("FontName"=>"diagrams/fonts/pf_arma_five.ttf","FontSize"=>9));

/* Define the chart area */
$myPicture2->setGraphArea(80,40,$ImageWidth-20,350);

/* Draw the scale */
$scaleSettings2 = array("XMargin"=>10,"YMargin"=>10, "Floating"=>TRUE,"GridR"=>200, "GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,
    "CycleBackground"=>TRUE, "LabelSkip"=>$lblSkip);
$myPicture2->drawScale($scaleSettings2);

/* Turn on Antialiasing */
$myPicture2->Antialias = TRUE;

/* Draw the line of best fit */
# $myPicture->drawBestFit();

/* Turn on shadows */
$myPicture2->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));


/* Draw the line chart */
$myPicture2->drawSplineChart(array("DisplayColor"=>DISPLAY_AUTO));

/* Write the chart legend */
$myPicture2->drawLegend(400,35,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL, "R"=>255,"G"=>255,"B"=>255));



$myPicture2->render("pictures/mypic2.png");
echo '<p  style="text-align: center;"><img src="pictures/mypic2.png"></p>';

?>
<?php Footer() ?>
</body>
</html>