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

    $sql = "SELECT song_name, artist_name, cover_link FROM songs WHERE isPresent = 1";
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
    <link rel="stylesheet" href="contribute.css">
    <script src="contribute.js" defer></script>
    <title>Document</title>
</head>
<body>
    <div id="topBar">
        <a href=about.html class="topLink">About</a>
        <a href=versus.php class="topLink">Versus</a>
        <a href=leaderboard.php class="topLink">Leaderboard</a>
        <a href=contribute.php class="topLink" id="contribute">Contribute</a>
    </div>
    <div id="whiteLine"></div>
    <div id="mainArea">
        <div id="leftSpace">
            <div id="addTitle">Add</div>
            <div id="leftBox">
                <div id="searchContainer">
                    <input type="text" id="searchBar" placeholder="Search for a song">
                    <button id="searchButton">Search</button>
                </div>
                <div id="possibleSongs">
                    <div class="addObj">
                        <div class="leftSide" >
                            <img class="albumCoverAdd" src="img/ab67616d0000b273c7ea04a9b455e3f68ef82550.jpg"></img>
                            <div class="songDetailsAdd">
                                <div class="songNameAdd">Over My Dead Body</div>
                                <div class="artistNameAdd">Drake</div>
                            </div>
                        </div>
                        <div class="rightSide">
                            <button class="addButton" onclick="addToList(this)">
                                <img class="add" src="img/addicon.png">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="rightSpace">
            <div id="deleteTitle">Delete</div>
            <div id="rightBox">
                <?php
                    $rowNumber = 1;
                    while ($row = $results->fetch_assoc()): ?>
                        <div class="boardObj" style="<?php echo ($rowNumber % 2 != 1) ? 'background-color: rgb(8, 8, 8);' : ''; ?>">
                            <div class="leftSide" >
                                <img class="albumCover" src="<?php echo $row['cover_link']; ?>">
                                <div class="songDetails">
                                    <div class="songName"><?php echo htmlspecialchars($row['song_name']); ?></div>
                                    <div class="artistName"><?php echo htmlspecialchars($row['artist_name']); ?></div>
                                </div>
                            </div>
                            <div class="rightSide">
                                <button class="deleteButton" onclick="deleteFromList(this)">
                                    <img class="delete" src="img/delete-512.png">
                                </button>
                            </div>
                        </div>              
                        <?php 
                            $rowNumber++; 
                            endwhile; 
                        ?>
                <?php $mysqli->close(); ?> 
            </div>
        </div>
    </div>
</body>
</html>