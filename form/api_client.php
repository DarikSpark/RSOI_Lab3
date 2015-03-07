<?php
if ($Module == 'client') {
    header('Content-type: application/json');
    $token = getallheaders();
    $token = $token['Authorization'];
    $token = substr($token, 7);

    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user_id`, `expired` FROM `oauth_apps_codes`
    WHERE `token`='$token'"));
    $user_id = $arr['user_id'];
    if (floatval($arr['expired']) >= floatval(strtotime('now'))) {
        $Row = mysqli_query($CONNECT, "SELECT * FROM clients");
        $response = array(
            "page"=>1,
            "count_entry"=>0,
            "per_page"=>5,
            "count_page" => 0

        );
        $i = 0;

        while ($myrowclient = mysqli_fetch_array($Row))
        {
            $response[$i] = array(
                "statusClient"=>$myrowclient['statusClient'],
                "fio"=>$myrowclient['lastName'].' '.$myrowclient['firstName'].' '.$myrowclient['secondName'],
                "link"=>'http://www.rosescrm.brottys.ru/edit_client_form.php?clientID='.$myrowclient['clientID'],
                "telephone"=>$myrowclient['telephone'],
                "company"=>$myrowclient['company'],
                "carier"=>$myrowclient['carier']
            );
            $i++;
        }

        if ($_GET['per_page'] != 'all')
        {
            $per_page = 5;
            if ($_GET['per_page']) {$per_page = $_GET['per_page'];}

            $page_count = round($i/$per_page, 0, PHP_ROUND_HALF_UP);
            if ($i%$per_page != 0) {$page_count++;}

            if ($_GET['page']){
                $response_paging = array_slice($response, ($_GET['page']-1)*5, $per_page);
            }
            else {$response_paging = $response;}

            $response_paging['page']=floatval($_GET['page']);
            $response_paging['count_entry']=$i;
            $response_paging['per_page']=floatval($per_page);
            $response_paging['count_page']= $page_count;

            $jsonString = json_encode($response_paging);
        }
        else {
            $response['page']=1;
            $response['count_entry']=$i;
            $response['per_page']=$per_page;
            $response['count_page']= 1;
            $jsonString = json_encode($response);
        }

        echo $jsonString;
    }
    else {
        $response = array(
            "token"=>$token,
            "Error"=>"Истекло время действия сессии"
        );
        $jsonString = json_encode($response);
        echo $jsonString;
        header("HTTP/1.0 401 Unauthorized");
//        echo 'Expired: '.floatval($arr['expired']).'     Текущее время: '.floatval(strtotime('now'));
    }
}

if ($Module == 'client_by_id') {
    header('Content-type: application/json');
    $token = getallheaders();
    $token = $token['Authorization'];
    $token = substr($token, 7);

    $arr = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user_id`, `expired` FROM `oauth_apps_codes`
    WHERE `token`='$token'"));
    $user_id = $arr['user_id'];
    if (floatval($arr['expired']) >= floatval(strtotime('now'))) {
        $Row = mysqli_query($CONNECT, "SELECT * FROM clients");
        $response = array(
            "page"=>1,
            "count_entry"=>0,
            "per_page"=>5,
            "count_page" => 0

        );
        $i = 0;

        while ($myrowclient = mysqli_fetch_array($Row))
        {
            $response[$myrowclient['clientID']] = array(
                "statusClient"=>$myrowclient['statusClient'],
                "fio"=>$myrowclient['lastName'].' '.$myrowclient['firstName'].' '.$myrowclient['secondName'],
                "link"=>'http://www.rosescrm.brottys.ru/edit_client_form.php?clientID='.$myrowclient['clientID'],
                "telephone"=>$myrowclient['telephone'],
                "company"=>$myrowclient['company'],
                "carier"=>$myrowclient['carier']
            );
            $i++;
        }

        if ($_GET['per_page'] != 'all')
        {
            $per_page = 5;
            if ($_GET['per_page']) {$per_page = $_GET['per_page'];}

            $page_count = round($i/$per_page, 0, PHP_ROUND_HALF_UP);
            if ($i%$per_page != 0) {$page_count++;}

            if ($_GET['page']){
                $response_paging = array_slice($response, ($_GET['page']-1)*5, $per_page);
            }
            else {$response_paging = $response;}

            $response_paging['page']=floatval($_GET['page']);
            $response_paging['count_entry']=$i;
            $response_paging['per_page']=floatval($per_page);
            $response_paging['count_page']= $page_count;

            $jsonString = json_encode($response_paging);
        }
        else {
            $response['page']=1;
            $response['count_entry']=$i;
            $response['per_page']=$per_page;
            $response['count_page']= 1;
            $jsonString = json_encode($response);
        }

        echo $jsonString;
    }
    else {
        $response = array(
            "token"=>$token,
            "Error"=>"Истекло время действия сессии"
        );
        $jsonString = json_encode($response);
        echo $jsonString;
        header("HTTP/1.0 401 Unauthorized");
//        echo 'Expired: '.floatval($arr['expired']).'     Текущее время: '.floatval(strtotime('now'));
    }
}
?>