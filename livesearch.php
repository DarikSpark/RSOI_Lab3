<!DOCTYPE html>
<html>
<head>
    <title>Простой живой поиск</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="http://yandex.st/jquery/1.7.2/jquery.min.js"></script>

    <style>
        .search_area{
            width: 350px;
            margin: 0px;
            position: relative;
        }
 
        #search_box{
            width:200px;
            padding:2px;
            margin:1px;
            border:1px solid #000;
        }
 
        #search_advice_wrapper{
            display:none;
            width: 350px;
            background-color: rgb(80, 80, 114);
            color: rgb(255, 227, 189);
            -moz-opacity: 0.95;
            opacity: 0.95;
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=95);
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=95);
            filter:alpha(opacity=95);
            z-index:999;
            position: absolute;
            top: 24px; left: 0px;
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
 
    </style>
</head>

<body>
	<script src="jquery.js"></script>
    <div class="search_area">
        <form action="" method="GET">
            <input type="text" name="query" id="search_box" value="" autocomplete="off">
            <input type="submit" value="Поиск">
        </form>
        <div id="search_advice_wrapper"></div>
    </div>

    <form action="" method="GET">
        <label>ID:</label>
        <input type="text" id="id_box" value="" autocomplete="off">
    </form>
</body>
</html>