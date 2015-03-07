<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
    <table border="1" style="width: 100%">
        <tr>
            <td style="width: 30%">

                <form action="filter.php" method="get" name="deal_filter" id="filter_form">
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

                            if (isset($_GET['managerID'])) {
                                $managerIDs = $_GET['managerID'];

                                $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                                mysql_select_db("user43199_roses", $db);

                                mysql_set_charset('utf8');

                                $query = 'SELECT * FROM bargain WHERE ';

                                for ($i = 0; $i < count($managerIDs); $i++) {
                                    $query .= 'managerID = ' . $managerIDs[$i];
                                    if ($i + 1 != count($managerIDs))
                                        $query .= ' OR ';
                                }

                                $selbargain = mysql_query($query);

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
                                }
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