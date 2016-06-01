<?php
    require 'config.php';
    header('Content-Type: application/json');

    $array = array();

    // Accounts
    if(isset($_GET['cat']) && $_GET['cat'] == 1) {
        $query = 'SELECT * FROM fiveonit ORDER BY id ASC';
        $result = mysql_query($query, $conn);
        $arrayAcc = array();

        while($item = mysql_fetch_assoc($result)) {
            $arrayAcc[] = $item;
        }

        $array = array('accounts' => $arrayAcc);
    }

    // Rooms
    else if(isset($_GET['cat']) && $_GET['cat'] == 2) {
        if(isset($_GET['id'])) {
            $queryR = 'SELECT owner, userId, name, email FROM fiveonitauth 
                    INNER JOIN fiveonit ON fiveonitauth.userId=fiveonit.id
                    INNER JOIN fiveonitrooms ON fiveonitauth.roomId=fiveonitrooms.id
                    WHERE fiveonitrooms.id = '. $_GET['id'] .' ORDER BY fiveonitauth.id ASC';
            $resultR = mysql_query($queryR, $conn);
            $arrayRooms = array();
            $nameOwner = '';

            while($itemR = mysql_fetch_assoc($resultR)) {
                $arrayRooms[] = $itemR;
                
                if($itemR['owner'] == 1) {
                    $nameOwner = $itemR['name'];
                }
            }

            $array = array('owner' => $nameOwner, 'authenticated' => $arrayRooms);
        }
        else {
            $queryR = 'SELECT * FROM fiveonitrooms ORDER BY id ASC';
            $resultR = mysql_query($queryR, $conn);
            $arrayRooms = array();
            $countRooms = 0;

            while($itemR = mysql_fetch_assoc($resultR)) {
                $arrayRooms[] = $itemR;

                if($itemR['available'] == 1) {
                    $countRooms++;
                }
            }

            $arrayHotel = array('roomsAvailable' => $countRooms, 'rooms' => $arrayRooms);
            $array = array('hotel' => $arrayHotel);
        }
    }

    // Everything
    else {
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

        $arrayHotel = array('roomsAvailable' => $countRooms, 'rooms' => $arrayRooms);
        $array = array('accounts' => $arrayAcc, 'hotel' => $arrayHotel);
    }

    // Output
    echo json_encode($array);
    mysql_close($conn);
?>
