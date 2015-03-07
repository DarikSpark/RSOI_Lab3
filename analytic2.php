<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Аналитика</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">
<style type="text/css">
body
{
   margin: 0;
   padding: 0;
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<style type="text/css">
a
{
   color: #0000FF;
   text-decoration: underline;
}
a:visited
{
   color: #800080;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #0000FF;
   text-decoration: underline;
}
h1
{
   font-family: Arial;
   font-size: 32px;
   font-weight: bold;
   font-style: normal;
   text-decoration: none;
   color: #000000;
   background-color: transparent;
   margin: 0px 0px 0px 0px;
   padding: 0px 0px 0px 0px;
   display: inline;
}
</style>
<style type="text/css">
#TabMenu1
{
   text-align: left;
   float: left;
   margin: 0;
   width: 100%;
   font-family: Arial;
   font-size: 13px;
   font-weight: normal;
   border-bottom: 1px solid #C0C0C0;
   list-style-type: none;
   padding: 15px 0px 4px 10px;
   overflow: hidden;
}
#TabMenu1 li
{
   float: left;
}
#TabMenu1 li a.active, #TabMenu1 li a:hover.active
{
   background-color: #FFFFFF;
   color: #666666;
   position: relative;
   font-weight: normal;
   text-decoration: none;
   z-index: 2;
}
#TabMenu1 li a
{
   padding: 5px 14px 8px 14px;
   border: 1px solid #C0C0C0;
   border-top-left-radius: 5px;
   border-top-right-radius: 5px;
   background-color: #EEEEEE;
   color: #666666;
   margin-right: 3px;
   text-decoration: none;
   border-bottom: none;
   position: relative;
   top: 0;
   -webkit-transition: 200ms all linear;
   -moz-transition: 200ms all linear;
   -ms-transition: 200ms all linear;
   transition: 200ms all linear;
}
#TabMenu1 li a:hover
{
   background: #C0C0C0;
   color: #666666;
   font-weight: normal;
   text-decoration: none;
   top: -4px;
}
#wb_Text1 div
{
   text-align: left;
}
</style>
</head>
<body>
<div id="wb_TabMenu1" style="position:absolute;left:0px;top:0px;width:281px;height:60px;z-index:0;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="./bargain.php">Сделки</a></li>
<li><a href="./client.php">Клиенты</a></li>
<li><a href="./analytic.php" class="active">Аналитика</a></li>
</ul>
</div>
<div id="wb_Text1" style="position:absolute;left:13px;top:43px;width:112px;height:24px;z-index:1;text-align:left;" class="Heading 1 <h1>">
<span style="color:#696969;font-family:Arial;font-size:21px;">Аналитика</span></div>
<br>
<br>
<br>



    <table border="1" style="width: 100%;">
        <tr>
            <td style="width: 30%">

                <form action="analytic.php" method="get" name="deal_filter" id="filter_form">
                    Бюджет:<br>
                    От:<input id="budget_from" value="" type="text">
                    До:<input id="budget_to" value="" type="text"><br><br>
                    Статус сделки:<br>
                    <input id="bs1" value="-1" type="checkbox"><label for="bs1">Первичный контакт</label><br>
                    <input id="bs2" value="-1" type="checkbox"><label for="bs2">Переговоры</label><br>
                    <input id="bs3" value="-1" type="checkbox"><label for="bs3">Принимают решение</label><br>
                    <input id="bs4" value="-1" type="checkbox"><label for="bs4">Согласование договора</label><br>
                    <input id="bs5" value="-1" type="checkbox"><label for="bs5">Успешно реализовано</label><br>
                    <input id="bs6" value="-1" type="checkbox"><label for="bs6">Закрыто и не реализовано</label><br><br>
                    Ответственный:<br>
                    <?php
                        $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                        mysql_select_db("user43199_roses", $db);

                        mysql_set_charset('utf8');

                        $result = mysql_query("SELECT managerID, lastName, firstName FROM manager");
                        $i=0;
                        while($row = mysql_fetch_array($result))
                        {
                            $i++;
                            echo '<input id="man'.$i.'" value="'.$row['managerID'].'" type="checkbox" name="managerID[]">'.
                                 '<label for="man'.$i.'">'.$row['lastName'].' '.$row['firstName'].'</label><br>';

                        }
                    ?>
                    <br>
                    <input type="submit" value="Найти">
                </form>
            </td>
            <td>
                <table align="center">
                    <thead>
                        <th>Компания</th>
                        <th>Контактное лицо</th>
                        <th>Телефон</th>
                        <th>Статус сделки</th>
                        <th>Бюджет (руб)
                    </thead>

                    <tbody>

                        <?php

                        foreach ($_GET['managerID'] as $key => $value) echo "$value <br>";

                            if (isset($_POST['managerID'])) {
                                $managerIDs = $_POST['managerID'];
                            }

                            $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                            mysql_select_db("user43199_roses", $db);

                            mysql_set_charset('utf8');

                            $query = 'SELECT * FROM bargain WHERE ';

                            for ($i = 0; $i < count($_POST['managerID']); $i++) {
                                echo $_POST['managerID'][$i];
                            }

                        /*
                            $selbargain = mysql_query('SELECT * FROM bargain');

                            foreach ($_POST['managerID'] as $key => $value) echo "$value <br>";



                            while ($myrowbargain = mysql_fetch_array($selbargain))
                            {
                                $selclient = mysql_query("SELECT * FROM clients WHERE clientID='".$myrowbargain['clientID']."'");
                                $myrowclient = mysql_fetch_array($selclient);
                                echo '<tr class="odd"><td align="right" class="data inline_edit not_null odd  nowrap ">'.$myrowclient['clientID'].'</td>';
                                echo '<td  class="data inline_edit  odd  ">'.$myrowclient['lastName'].$myrowclient['firstName'].$myrowclient['secondName'].'</td>';
                                echo '<td  class="data inline_edit  odd  ">'.$myrowclient['telephone'].'</td>';
                                echo '<td  class="data inline_edit  odd  ">'.$myrowbargain['statusBargain'].'</td>';
                                echo '<td  class="data inline_edit  odd  ">'.$myrowbargain['budget'].'</td>';
                                echo '</tr>';
                            }*/
                        ?>

                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>