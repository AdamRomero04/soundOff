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
    
    $sql = "SELECT song_name, artist_name, cover_link FROM songs 
            WHERE isPresent = 1
            ORDER BY RAND()
            LIMIT 2";
    $results = $mysqli->query($sql);

    if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
    $row0 = $results->fetch_assoc();
    $row1 = $results->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="versus.css">
    <script src="versus.js" defer></script>
    <title>Document</title>
</head>
<body>
    <div id="topBar">
        <a href=about.html class="topLink">About</a>
        <a href=versus.php class="topLink" id="versus">Versus</a>
        <a href=leaderboard.php class="topLink">Leaderboard</a>
        <a href=contribute.php class="topLink">Contribute</a>
    </div>
    <div id="whiteLine"></div>
    <div id="topText"></div>
    <div id="mainBox">
        <div id="topPart">
            <button id="leftButton" onclick="songSelected(this)">
                <div id="leftBigBox">
                    <div id="leftContain">
                        <img id="leftImg" src="<?php echo $row0['cover_link']; ?>">
                        <div id="leftDesc">
                            <div id="leftSong" class="songName"><?php echo htmlspecialchars($row0['song_name']); ?></div>
                            <div id="leftArtist" class="artistName"><?php echo htmlspecialchars($row0['artist_name']); ?></div>
                        </div>
                    </div>
                </div>
            </button>

            <img src="img/output-onlinepngtools (3).png" id="vs">

            <button id="rightButton" onclick="songSelected(this)">
                <div id="rightBigBox">
                    <div id="rightContain">
                        <img id="rightImg" src="<?php echo $row1['cover_link']; ?>">
                        <div id="rightDesc">
                            <div id="rightSong" class="songName"><?php echo htmlspecialchars($row1['song_name']); ?></div>
                            <div id="rightArtist" class="artistName"><?php echo htmlspecialchars($row1['artist_name']); ?></div>
                        </div>
                    </div>
                </div>
            </button>
        </div>
        <div id="bottomPart">
            <button class="skipButton" onclick="refresh()">
                <img src="img/skip.png" id="skip">
            </button>
        </div>
    </div>
</body>
</html>