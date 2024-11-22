const searchInput = document.getElementById('searchBar');
const searchButton = document.getElementById('searchButton');

searchButton.addEventListener('click', function() {
    const searchTerm = searchInput.value;
    searchForSong(searchTerm);
});

async function getAccessToken(clientId, clientSecret) {
    const tokenUrl = 'https://accounts.spotify.com/api/token';

    const credentials = btoa(clientId + ':' + clientSecret);

    const response = await fetch(tokenUrl, {
        method: 'POST',
        headers: {
            'Authorization': 'Basic ' + credentials,
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'grant_type': 'client_credentials'
        })
    });

    const data = await response.json();
    
    return data.access_token;
}


async function searchForSong(song) {

    const cont = document.getElementById('possibleSongs');
    while (cont.children.length > 1){
        cont.removeChild(cont.lastChild);
    }

    const clientId = 'dbdce7c9d5b44b4d88dbd79b4a98dfb6';
    const clientSecret = '29b1d71096314784a5098ad361cf79df';
    const token = await getAccessToken(clientId, clientSecret);

    const response = await fetch(`https://api.spotify.com/v1/search?q=${song}&type=track`, {
        headers: {
            'Authorization': 'Bearer ' + token
        }
    });

    const data = await response.json();
    console.log(data);

    const tracksToIterate = data.tracks.items.slice(0, 3);
    let count = 0;
    tracksToIterate.forEach(track => {
        const trackName = track.name;
        let artists = "";
        if (track.artists.length == 1){
            artists = track.artists[0].name;
        }
        else if (track.artists.length == 2){
            artists += track.artists[0].name;
            artists += " & "
            artists += track.artists[1].name;
        }
        else{
            track.artists.forEach(artist=> {
                artists += artist.name;
                artists += ", "
            })
            artists = artists.slice(0, -2);
        }
        let songImage = track.album.images[0].url;

        const songObject = document.querySelector('.addObj');
        const newSong = songObject.cloneNode(true);
        newSong.style.display = "flex";
        
        const albumCover = newSong.querySelector('.albumCoverAdd');
        const songName = newSong.querySelector('.songNameAdd');
        const artistName = newSong.querySelector('.artistNameAdd');

        albumCover.src = songImage;
        songName.textContent = trackName;
        artistName.textContent = artists;

        if (count == 1){
            newSong.style.backgroundColor = "rgb(8, 8, 8)";
        }
        
        console.log(albumCover.src);
        console.log(songName.textContent);
        console.log(artistName.textContent);
        document.getElementById('possibleSongs').appendChild(newSong);
      });
}

function addToList(button){
    rightBox = document.getElementById('rightBox');

    const addObj = button.closest('.addObj');
    const albumCoverTake = addObj.querySelector('.albumCoverAdd').src;
    const songNameTake = addObj.querySelector('.songNameAdd').textContent;
    const artistNameTake = addObj.querySelector('.artistNameAdd').textContent;

    const deleteObj = document.querySelector('.boardObj');
    const newSong = deleteObj.cloneNode(true);

    const albumCover = newSong.querySelector('.albumCover');
    const songName = newSong.querySelector('.songName');
    const artistName = newSong.querySelector('.artistName');

    for (const child of rightBox.children) {
        const targetName = child.querySelector('.songName').textContent;
        const targetArtist = child.querySelector('.artistName').textContent;
        if (targetName === songNameTake && artistNameTake === targetArtist){
            return;
        }
    }

    newSong.style.display = "flex";
    albumCover.src = albumCoverTake;
    songName.textContent = songNameTake;
    artistName.textContent = artistNameTake;
    if (rightBox.children.length % 2 == 1){
        console.log(rightBox.children.length);
        newSong.style.backgroundColor = "rgb(8, 8, 8)";
    }
    rightBox.appendChild(newSong);

    const data = {
        albumCover: albumCoverTake,
        songName: songNameTake,
        artistName: artistNameTake,
    };

    fetch('addToSongList.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
        .then(response => response.text())
        .then(result => {
            console.log(result);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function deleteFromList(button){
    const deleteObj = button.closest('.boardObj');
    const songName = deleteObj.querySelector('.songName').textContent;
    const artistName = deleteObj.querySelector('.artistName').textContent;

    rightBox = document.getElementById('rightBox');
    rightBox.removeChild(deleteObj);
    const data = {
        songName: songName,
        artistName: artistName,
    };

    fetch('deleteFromSongList.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
        .then(response => response.text())
        .then(result => {
            console.log(result);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
