<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Форма добавления сделки</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">




<!-- edit -->


<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

<style type="text/css">
body
{
   margin: 0;
   padding: 0;
   background-color: #FFFFFF;
   color: #000000;
}
</style>
<link href="cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
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
#jQueryButton1
{
   font-family: Arial;
   font-size: 13px;
   font-weight: normal;
   font-style: normal;
}
#wb_jQueryButton1 .ui-button-text
{
   padding: 0;
   line-height: 31px;
}
#jQueryButton1
{
   color: #2779AA;
}
#jQueryButton1 :hover
{
   color: #0070A3;
}
#jQueryButton1 :active
{
   color: #FFFFFF;
}
#wb_jQueryButton1 .ui-button-text-icon .ui-button-icon-primary,
#wb_jQueryButton1 .ui-button-text-icons .ui-button-icon-primary,
#wb_jQueryButton1 .ui-button-icons-only .ui-button-icon-primary
{
   left: auto;
   right: 10px;
}
#wb_jQueryButton1 .ui-button-text-icons .ui-button-icon-secondary,
#wb_jQueryButton1 .ui-button-icons-only .ui-button-icon-secondary
{
   right: auto;
   left: 10px;
}
#wb_Text1 div
{
   text-align: left;
}
</style>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="jquery.ui.core.min.js"></script>
<script type="text/javascript" src="jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="jquery.ui.button.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   $("#jQueryButton1").button();
});
</script>





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
</style>


<!-- ################# -->



    <script src="http://yandex.st/jquery/1.7.2/jquery.min.js"></script>
	
    <style>


        #search_box{
		  position:absolute;
		  width: 200px;
		  padding: 2px;
		  margin: 1px;
		  border: 1px solid #000;
		  left: 120px;
        }
		#statusBargain {position:absolute; left:120px;width:200px;}
		#plantation	{position:absolute; left:120px;width:200px;}
		#sort	{position:absolute; left:120px;width:200px;}
		#length	{position:absolute; left:120px;width:200px;}
		#count	{position:absolute; left:120px;width:200px;}
		#city	{position:absolute; left:120px;width:200px;}
		#budget	{position:absolute; left:120px;width:200px;}
		#note   {width:320px;}		
		#submit {position:absolute; left:120px;width:200px;}

 
        #search_advice_wrapper{
            display:none;
            width: 200px;
            background-color: rgb(80, 80, 114);
            color: rgb(255, 227, 189);
            -moz-opacity: 0.95;
            opacity: 0.95;
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=95);
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
            filter:alpha(opacity=95);
            z-index:999;
            position: absolute;
            top: 58px; left: 120px;
        }
 
        #search_advice_wrapper .advice_variant{
            cursor: pointer;
            padding: 5px;
            text-align: left;
        }
        #search_advice_wrapper .advice_variant:hover{
            color:#FEFFBD;
            background-color:#818187;
        }
        #search_advice_wrapper .active{
            cursor: pointer;
            padding: 5px;
            color:#FEFFBD;
            background-color:#818187;		
			
        }
		
		
?>
		
 
    </style>
    <style type="text/css">
    </style>


</head>
<body>




<div id="wb_TabMenu1" style="position:absolute;left:0px;top:0px;width:281px;height:60px;z-index:0;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="./bargain.php" class="active">Сделки</a></li>
<li><a href="./client.php">Клиенты</a></li>
<li><a href="./analytic.php">Аналитика</a></li>
</ul>
</div>
<div id="wb_Text1" style="position:absolute;left:12px;top:43px;width:91px;height:24px;z-index:2;text-align:left;" class="Heading 1 <h1>">
<span style="color:#696969;font-family:Arial;font-size:21px;">Сделки</span></div>
 <div id="wb_jQueryButton1" style="position:absolute;left:13px;top:50px;width:152px;height:31px;z-index:1;">
<!--<a href="./new_bargain.php" id="jQueryButton1" style="width:100%;height:100%;">Добавить сделку</a></div> -->




<!-- ################################ -->





<script src="jquery.js"></script>

<form action="add_bargain.php" method="post" name="bargainForm" target="_blank" >

  <p>
  <br>
  Клиент:  		      
    <label for="clientID"></label>
    <input type="text" name="query" id="search_box" value="" autocomplete="off">
	<script>
	function replace() {
	 if(this.value.length==1) {
	  if(/^[^А-ЯЁ]$/.test(this.value)) this.value = String.fromCharCode(this.value.charCodeAt(this.value)-32);
	 } else if(/[^а-яё ]/.test(this.value[this.value.length-1])) {this.value = this.value.slice(0,-1)};
	} ;
	document.getElementById("clientID").onkeyup = replace ;
	</script>
   
    <label for="clientID"></label>
    <input type="text" name="clientID" id="clientID" style="position:absolute; left:400px; visibility:hidden;">
  <div id="search_advice_wrapper">


<br />
    <br />
    Выберите менеджера: 
    <label for="managerName"></label>
    <select name="managerName" id="managerName">
      <?php
    
    
	  $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	  mysql_select_db("user43199_roses", $db);
	  
	  mysql_set_charset('utf8');
	  
	  $result = mysql_query("SELECT lastName, firstName FROM manager ");
	  $i=0;
	  while($row = mysql_fetch_array($result))
	  {
		  if($i=0) printf("<option selected=\"selected\">%s %s</option>", $row['lastName'], $row['firstName']);;
		  printf("<option>%s %s</option>", $row['lastName'], $row['firstName']);
		  $i++;
	  
	  }
    
 	?>    
    </select>
    <br />
    <br />
  <em><strong>  Введите данные заказа: </strong></em><strong></strong> </p>
  </div>
    <p>Плантация: 
      <label for="plantation"></label>
    <select name="plantation" id="plantation">
	 <?php
    
    
	  $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	  mysql_select_db("user43199_roses", $db);
	  
	  mysql_set_charset('utf8');
	  
	  $result = mysql_query("SELECT plantation FROM sort ");
	  $i=0;
	  while($row = mysql_fetch_array($result))
	  {
		  if($i=0) printf("<option selected=\"selected\">%s</option>", $row['plantation']);;
		  printf("<option>%s</option>", $row['plantation']);
		  $i++;
	  
	  }
    
 	?>
    </select>
  </p>
  <p>Сорт:
    <label for="sort"></label>
    <select name="sort" id="sort">
	 <?php
    
    
	  $db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
	  mysql_select_db("user43199_roses", $db);
	  
	  mysql_set_charset('utf8');
	  
	  $result = mysql_query("SELECT sort FROM sort");   // WHERE plantation= '$plantation'
	  $i=0;
	  while($row = mysql_fetch_array($result))
	  {
		  if($i=0) printf("<option selected=\"selected\">%s</option>", $row['sort']);;
		  printf("<option>%s</option>", $row['sort']);
		  $i++;
	  
	  }
    
 	?>    
    </select>
  </p>
  <p>Длина: 
    <label for="length"></label>
    <select name="length" id="length">
      <option>20</option>
      <option>30</option>
      <option>40</option>
      <option>50</option>
      <option selected="selected">60</option>
      <option>70</option>
      <option>80</option>
      <option>90</option>
      <option>100</option>
    </select>
  </p>
  <p>Количество:
    <label for="count"></label>
    <input type="text" name="count" id="count" />
  </p>



  <p>Город доставки:
    <label for="city"></label>
    <select name="city" id="city">
      <?php
	  	
		
		$db = mysql_connect("localhost", "user43199_roses", "jGTlDnaC");
		mysql_select_db("user43199_roses", $db);
		
		mysql_set_charset('utf8');
		
		$result = mysql_query("SELECT city FROM city ");
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			if($i=0) printf("<option selected=\"selected\">%s</option>", $row['city']);;
			printf("<option>%s</option>", $row['city']);
			$i++;
		
		}
		
	  ?>
    </select>
  </p>
  <p>Статус сделки: 
    <label for="statusBargain"></label>
    <select name="statusBargain" id="statusBargain">
      <option selected="selected">Первичный контакт</option>
      <option>Переговоры</option>
      <option>Принимают решение</option>
      <option>Согласование договора</option>
      <option>Заказ товара</option>
      <option>Товар отгружен</option>
      <option>Успешное завершение</option>
      <option>Закрыто и не реализовано</option>
    </select>
  </p>
  <p>Бюджет: 
    <label for="budget"></label>
    <input type="text" name="budget" id="budget" />
  </p>
  <p>Введите дополнительный комментарий:</p>
  <p>
  <label for="note"></label>
    <textarea name="note" id="note" cols="45" rows="5"></textarea>
  </p>
  <p>
    <label for="menu"></label>
    <input type="submit" name="submit" id="submit" value="Отправить" />
    <br />
  </p>

</form>



</body>
</html>