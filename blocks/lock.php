<?php
include("blocks/db.php");
/*
if (!isset($_SERVER['PHP_AUTH_USER']))

{
        Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
        Header ("HTTP/1.0 401 Unauthorized");
        exit();
}

else {
        if (!get_magic_quotes_gpc()) {
                $_SERVER['PHP_AUTH_USER'] = mysql_escape_string($_SERVER['PHP_AUTH_USER']);
                $_SERVER['PHP_AUTH_PW'] = mysql_escape_string($_SERVER['PHP_AUTH_PW']);
        }

        $query = "SELECT pass, managerID FROM userlist WHERE user='".$_SERVER['PHP_AUTH_USER']."'";
        $lst = @mysql_query($query);

        if (!$lst)
        {
            Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
        Header ("HTTP/1.0 401 Unauthorized");
        exit();
        }

        if (mysql_num_rows($lst) == 0)
        {
           Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
           Header ("HTTP/1.0 401 Unauthorized");
           exit();
        }

        $pass =  @mysql_fetch_array($lst);
        if ($_SERVER['PHP_AUTH_PW']!= $pass['pass'])
        {
            Header ("WWW-Authenticate: Basic realm=\"Admin Page\"");
           Header ("HTTP/1.0 401 Unauthorized");
           exit();
        }
		*/
//$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
//mysql_select_db("user43199_roses", $db);
//
//mysql_set_charset('utf8');

		$managerID = $_SESSION['USER_ID']; # $pass['managerID'];
//		$managersel = mysql_query("SELECT lastName, firstName, secondName FROM manager WHERE managerID='".$managerID."'");
//		$managerrow = mysql_fetch_array($managersel);
//		$managerFIO = $managerrow['lastName'].' '.$managerrow['firstName'].' '.$managerrow['secondName'];
//		echo '<pre style="text-align:right"><font face="Verdana" size=3 color="blue">Вы авторизованы как: <ins><strong>'.$managerFIO.'</strong></ins></font> [<a title="Выйти из личного кабинета" href="http://www.rosescrm.brottys.ru/exit.php">Выход</a>]  </pre>';
#}




?>