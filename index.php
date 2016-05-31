<?php
    require 'config.php';
    header('Content-Type: application/json');

    $array = array();
            
    $query = 'SELECT * FROM fiveonit ORDER BY id ASC';
    $result = mysql_query($query, $conn);
    $arrayAcc = array();

    $queryR = 'SELECT * FROM fiveonitrooms ORDER BY id ASC';
    $resultR = mysql_query($queryR, $conn);
    $arrayRooms = array();
    $countRooms = 0;

    while($item = mysql_fetch_assoc($result)) {
        $arrayAcc[] = $item;
    }
    while($itemR = mysql_fetch_assoc($resultR)) {
        $arrayRooms[] = $itemR;

        if($itemR['available'] == 1) {
            $countRooms++;
        }
    }

    $arrayHotel = array('roomsAvailable' => $countRooms, 
                        'rooms' => $arrayRooms);
    $array = array('accounts' => $arrayAcc, 
                   'hotel' => $arrayHotel);
        
    echo json_encode($array);
    mysql_close($conn);
?>