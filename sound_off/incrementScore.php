<?php
    $data = file_get_contents("php://input");
    $realData = json_decode($data, true);
    if (empty($realData)){
        echo "Data empty";
    }
    else{
        $songName = $realData['songName'];
        $artistName = $realData['artistName'];

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

        $sql = "UPDATE leaderboard 
                JOIN songs ON songs.song_id = leaderboard.song_id
                SET score = score + 1 WHERE songs.song_name = '$songName' AND songs.artist_name = '$artistName'";
        $result = $mysqli->query($sql);

        if (!$result) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }
        $mysqli->close();
    }
?>