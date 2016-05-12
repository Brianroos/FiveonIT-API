<?php
    require 'config.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $accept = $_SERVER['HTTP_ACCEPT'];

    switch($method) {
        case 'GET':
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
                
                if($itemR[available] == 1) {
                    $countRooms++;
                }
            }
            
            $arrayHotel = array('roomsAvailable' => $countRooms, 
                                'rooms' => $arrayRooms);
            
            if($accept == 'application/json') {
                header('Content-Type: application/json');
                
                $array = array('accounts' => $arrayAcc, 
                               'hotel' => $arrayHotel);
                echo json_encode($array);
            } else {
                http_response_code(415); // Media unsupported
            }
            
            break;
        case 'POST':
            break;
        case 'PUT':
            break;
        case 'DELETE':
            break;
        case 'OPTIONS':
            header('Allow: GET, POST, PUT, DELETE, OPTIONS');
            break;
        default:
            http_response_code(405); // Method not allowed
            break;
    }

    mysql_close($conn);
?>