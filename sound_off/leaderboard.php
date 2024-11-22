<?php
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

    $sql = "SELECT songs.song_name AS song_name, songs.artist_name AS artist_name,
                    songs.cover_link AS cover_link, leaderboard.score AS score,
                    leaderboard.song_id AS song_id
                FROM songs
                LEFT JOIN leaderboard ON songs.song_id = leaderboard.song_id
                WHERE songs.isPresent = 1
                ORDER BY 
                leaderboard.score DESC";

    $results = $mysqli->query($sql);

    if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="leaderboard.css">
    <title>Document</title>
</head>
<body>
    <div id="topBar">
        <a href=about.html class="topLink">About</a>
        <a href=versus.php class="topLink">Versus</a>
        <a href=leaderboard.php class="topLink" id="leaderboard">Leaderboard</a>
        <a href=contribute.php class="topLink">Contribute</a>
    </div>
    <div id="whiteLine"></div>
    <div id="leaderboardTitle">
        <div>Leaderboard</div>
    </div>
    <div id="mainBox">
    <?php 
        $rowNumber = 1; 
        while ($row = $results->fetch_assoc()): ?>
            <div class="boardObj" 
            style="<?php echo ($rowNumber % 2 != 1) ? 'background-color: rgb(8, 8, 8);' : ''; ?>"
            <?php if ($rowNumber == 1) echo 'id="first"';  
                                        else if ($rowNumber == 2) echo 'id="second"'; 
                                        else if ($rowNumber == 3) echo 'id="third"';
                                    ?>
            >
                <div class="leftSide">
                    <div class="rank"><?php echo $rowNumber . '.'; ?></div> 
                    <img class="albumCover" src="<?php echo $row['cover_link']; ?>"></img>
                    <div class="songDetails">
                        <div class="songName"><?php echo $row['song_name']; ?></div>
                        <div class="artistName"><?php echo $row['artist_name']; ?></div>
                    </div>
                </div>
                <div class="rightSide">
                    <div class="score"><?php echo $row['score']; ?></div> 
                </div>
            </div>
            <?php 
                $rowNumber++; 
                endwhile; 
            ?>
        <?php $mysqli->close(); ?>
    </div>
</body>
</html>