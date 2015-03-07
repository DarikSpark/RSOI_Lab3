<?php
ULogin(1);
HeadCss('Персонал', '<link href="resource/bootstrap/dist/css/bootstrap.css" rel="stylesheet">') ?>

<body>
<div class="wrapper">
<?php HeaderLink(); ?>
<div class="content">
    <?php Menu();
    MessageShow()
    ?>

    <?php
    $managerID = $_SESSION['USER_ID'];
    if (isset($_GET['budget_from'])) {$budget_from = $_GET['budget_from']; }// if ($statusClient == '') {unset($statusClient);} }
    if (isset($_GET['budget_to'])) {$budget_to = $_GET['budget_to']; }// if ($statusClient == '') {unset($statusClient);} }
    if (isset($_GET['man'])) {$man = $_GET['man']; }// if ($statusClient == '') {unset($statusClient);} }
    #if (isset($_GET['statusBargain[]'])) {$statusBargID = $_GET['statusBargain[]']; }// if ($statusClient == '') {unset($statusClient);} }
    if (isset($_GET['managerID[]'])) {$manBargID = $_GET['managerID[]']; }// if ($statusClient == '') {unset($statusClient);} }

    ?>
<br>
    <div style="width: 25%; float:left; display: inline;  background: #ffffff;">
        <form action="analytic_personal.php" method="get" name="deal_filter" id="filter_form">
            Бюджет:<br>
            От:<input id="budget_from" type="text" name="budget_from" value="<?php echo $budget_from ?>"><br>
            До:<input id="budget_to" type="text" name="budget_to"  value="<?php echo $budget_to ?>"><br><br>

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
                   # if (i != $statusBargID)
                    #{
                    echo '<input id="status'.$i.'" value="'.$row['statusBargain'].
                        '" type="checkbox" name="statusBargain[]">'.
                        '<label for="status'.$i.'">'.$row['statusBargain'].'</label><br>';
                    /*}
                    else
                    {
                        echo '<input id="status'.$i.'" value="'.$row['statusBargain'].
                            '" type="checkbox" name="statusBargain[]" checked="checked">'.
                            '<label for="status'.$i.'">'.$row['statusBargain'].'</label><br>';
                    }*/
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
                    if (i != $manBargID)
                    {
                    echo '<input id="man'.$i.'" value="'.$row['managerID'].'" type="checkbox" name="managerID[]">'.
                         '<label for="man'.$i.'">'.$row['lastName'].' '.$row['firstName'].'</label><br>';
                    }
                    else
                        {
                            echo '<input id="man'.$i.'" value="'.$row['managerID'].'" type="checkbox" name="managerID[]" checked="checked">'.
                                '<label for="man'.$i.'">'.$row['lastName'].' '.$row['firstName'].'</label><br>';

                        }

                }
            ?>
            <br>
            <input type="submit" value="Найти">
        </form>
    </div>
    <div style="width: 75%; float:left; display: inline;  background: #ffffff;">
                    <table class="table table-hover"  style="cursor: default;">
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

                                //echo $query;

                                $selbargain = mysql_query($query);

                                while ($myrowbargain = mysql_fetch_array($selbargain))
                                {
                                    $selclient = mysql_query("SELECT * FROM clients WHERE clientID='".$myrowbargain['clientID']."'");
                                    $myrowclient = mysql_fetch_array($selclient);
                                    echo '<tr class="odd"><td class="data inline_edit not_null odd  nowrap ">'.$myrowclient['company'].'   </td>';
                                    echo '<td  class="data inline_edit  odd  "> '.$myrowclient['lastName'].' '.$myrowclient['firstName'].' '.$myrowclient['secondName'].'   </td>';
                                    echo '<td  class="data inline_edit  odd  "> '.$myrowclient['telephone'].'   </td>';
                                    echo '<td  class="data inline_edit  odd  "> '.$myrowbargain['statusBargain'].'   </td>';
                                    echo '<td  class="data inline_edit  odd  "> '.$myrowbargain['budget'].'   </td>';
                                    echo '</tr>';
                                }
                            ?>

                        </tbody>
                    </table>

        </table>
    </div>
        <?php Footer() ?>
</div>
</body>
</html>