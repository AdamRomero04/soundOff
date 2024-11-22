<?php
    $data = file_get_contents("php://input");
    $realData = json_decode($data, true);
    if (empty($realData)){
        echo "Data empty";
    }
    else{
        $albumCover = $realData['albumCover'];
        $songName = $realData['songName'];
        $artistName = $realData['artistName'];
        $isPresent = 1;

        $host = "303.itpwebdev.com";
        $user = "akromero_user";
        $pass = "AdamRomero1!";
        $db = "akromero_final_project";

        $mysqli = new mysqli($host, $user, $pass, $db);

        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            $mysqli->close();
            exit();
        }

        $sql = "INSERT INTO songs (song_name, artist_name, cover_link, isPresent)
            VALUES ('$songName', '$artistName', '$albumCover', $isPresent);";	
        $result = $mysqli->query($sql);

        if (!$result) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $sql = "SELECT song_id FROM songs WHERE song_name = '$songName' AND artist_name = '$artistName'";
        $result = $mysqli->query($sql);

        if (!$result) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $row = $result->fetch_assoc();
        $song_id = $row['song_id'];
        
        $sql = "INSERT INTO leaderboard (song_id, score)
            VALUES ('$song_id', 0);";	
        $result = $mysqli->query($sql);

        if (!$result) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $mysqli->close();
    }
?>