<!DOCTYPE html>
<html>
<head>
    <title>Форма добавления нового клиента</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            top: 38px; left: 120px;
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
<script src="jquery.js"></script>


<form action="add_bargain.php" method="post" name="bargainForm" target="_blank">

  <p>Клиент:  		      
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
  <div id="search_advice_wrapper">


<br />
    <br />
    Выбирите менеджера: 
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