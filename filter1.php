<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
    <table border="1" style="width: 100%">
        <tr>
            <td style="width: 30%; vertical-align: top">

                <form action="filter1.php" method="get" name="deal_filter" id="filter_form">
                    Бюджет:<br>
                    От:<input id="budget_from" type="text" name="budget_from">
                    До:<input id="budget_to" type="text" name="budget_to" "><br><br>

                    Статус сделки:<br>
                    <?php
                        $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                        mysql_select_db("user43199_roses", $db);

                        mysql_set_charset('utf8');

                        $result = mysql_query('SELECT DISTINCT statusBargain FROM bargain');
                        $i=0;
                        while ($row = mysql_fetch_array($result))
                        {
                            $i++;
                            echo '<input id="status'.$i.'" value="'.$row['statusBargain'].'" type="checkbox" name="statusBargain[]">'.
                                '<label for="status'.$i.'">'.$row['statusBargain'].'</label><br>';
                        }
                    ?>
                    <br>

                    Ответственный:<br>
                    <?php
                        $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                        mysql_select_db("user43199_roses", $db);

                        mysql_set_charset('utf8');

                        $result = mysql_query('SELECT managerID, lastName, firstName FROM manager');
                        $i=0;
                        while ($row = mysql_fetch_array($result))
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

                            // по умолчанию вот такой запрос
                            $query = 'SELECT * FROM bargain';

                            // если есть "бюджет от"
                            if ($_GET['budget_from'] != '') {
                                $query .= ' WHERE budget >= ' . $_GET['budget_from'];
                            }

                            // если есть "бюджет до"
                            if ($_GET['budget_to'] != '') {
                                if ($_GET['budget_from'] != '')
                                    $query .= ' AND';
                                else
                                    $query .= ' WHERE';

                                $query .= ' budget <= ' . $_GET['budget_to'];
                            }

                            // если выбран хотя бы один statusBargain
                            if (isset($_GET['statusBargain'])) {
                                $statusesBargain = $_GET['statusBargain'];

                                if ($_GET['budget_from'] != '' || $_GET['budget_to'] != '') {
                                    $query .= ' AND (';

                                    for ($i = 0; $i < count($statusesBargain); $i++) {
                                        $query .= 'statusBargain LIKE "' . $statusesBargain[$i] . '"';
                                        if ($i + 1 != count($statusesBargain))
                                            $query .= ' OR ';
                                    }

                                    $query .= ')';
                                } else {
                                    $query .= ' WHERE ';

                                    for ($i = 0; $i < count($statusesBargain); $i++) {
                                        $query .= 'statusBargain LIKE "' . $statusesBargain[$i] . '"';
                                        if ($i + 1 != count($statusesBargain))
                                            $query .= ' OR ';
                                    }
                                }
                            }

                            // если выбран хотя бы один менеджер
                            if (isset($_GET['managerID'])) {
                                $managerIDs = $_GET['managerID'];

                                if ($_GET['budget_from'] != '' || $_GET['budget_to'] != '' || isset($_GET['statusBargain'])) {
                                    $query .= ' AND (';

                                    for ($i = 0; $i < count($managerIDs); $i++) {
                                        $query .= 'managerID = ' . $managerIDs[$i];
                                        if ($i + 1 != count($managerIDs))
                                            $query .= ' OR ';
                                    }

                                    $query .= ')';
                                } else {
                                    $query .= ' WHERE ';

                                    for ($i = 0; $i < count($managerIDs); $i++) {
                                        $query .= 'managerID = ' . $managerIDs[$i];
                                        if ($i + 1 != count($managerIDs))
                                            $query .= ' OR ';
                                    }
                                }
                            }

                            // вытаскиваем данные из БД
                            $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
                            mysql_select_db("user43199_roses", $db);

                            mysql_set_charset('utf8');

                            echo $query;

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
                        ?>

                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>