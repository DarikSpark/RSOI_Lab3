<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Форма добавления клиента</title>
</head>
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

<body>
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
    <input type="submit" name="submitClient" id="submitClient" value="Отправить" />
  </p>
</form>
</body>
</html>