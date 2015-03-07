<?php
include("blocks/lock.php");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Форма добавления клиента</title>
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



<!-- ############################## -->

<style>
<?php
	
	$leftpx = '120px';
	$width = 200;
	echo "#statusClient {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#firstName {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#lastName {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#secondName {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#sex {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#company {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#carier {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#telephone {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#email {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#city {position: absolute; left: $leftpx; width: $width"."px}";	
	echo "#web {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#skype {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#address {position: absolute; left: $leftpx; width: $width"."px}";	
	echo "#verificity {position: absolute; left: $leftpx; width: $width"."px}";
	echo "#submitClient {position: absolute; width: 320px}";
?>	

</style>


</head>
<body>




<div id="wb_TabMenu1" style="position:absolute;left:0px;top:0px;width:281px;height:60px;z-index:0;overflow:hidden;">
<ul id="TabMenu1">
<li><a href="./bargain.php">Сделки</a></li>
<li><a href="./client.php" class="active">Клиенты</a></li>
<li><a href="./analytic.php">Аналитика</a></li>
</ul>
</div>
<div id="wb_Text1" style="position:absolute;left:12px;top:43px;width:91px;height:24px;z-index:2;text-align:left;" class="Heading 1 <h1>">
<span style="color:#696969;font-family:Arial;font-size:21px;">Клиенты</span></div>
 <div id="wb_jQueryButton1" style="position:absolute;left:13px;top:50px;width:152px;height:31px;z-index:1;">
<!--<a href="./new_bargain.php" id="jQueryButton1" style="width:100%;height:100%;">Добавить сделку</a></div> -->




<!-- ################################ -->





<form id="formClient" name="formClient" method="post" action="add_client.php" target="_blank">

  <p>Статус:   
    <label for="statusClient"></label>
    <select name="statusClient" id="statusClient">
      <option selected="selected">Нулевой</option>
      <option>Клиент</option>
      <option>Постоянный клиент</option>
      <option>Партнер</option>
    </select>
  </p>
  <p>Фамилия:
    <label for="lastName"></label>
    <input type="text" name="lastName" id="lastName" />
  </p>
  <p>Имя:
    <input type="text" name="firstName" id="firstName" />
  </p>
  <p>Отчество:
    <input type="text" name="secondName" id="secondName" />
  </p>
  <p>
    <label for="sex">Пол</label>
    <select name="sex" id="sex">
      <option selected="selected">Мужской</option>
      <option>Женский</option>
    </select>
  </p>
  <p>Компания:
    <label for="company"></label>
    <input type="text" name="company" id="company" />
  </p>
  <p>Должность:
    <input type="text" name="carier" id="carier" />
  </p>
  <p>Телефон:
    <input type="text" name="telephone" id="telephone" />
  </p>
  <p>E-mail: 
    <input type="text" name="email" id="email" />
  </p>
  <p>Город:
    <input type="text" name="city" id="city" />
  </p>
  <p>Сайт:
    <input type="text" name="web" id="web" />
  </p>
  <p>Skype:
    <input type="text" name="skype" id="skype" />
  </p>
  <p>Адрес:
    <input type="text" name="address" id="address" />
  </p>
  <p>Достоверно:
    <input type="checkbox" name="verificity" id="verificity" />
    <label for="verificity"></label>
  </p>
  <p>
    <input type="submit" name="submitClient" id="submitClient" value="Добавить" />
  </p>
</form>

</body>
</html>