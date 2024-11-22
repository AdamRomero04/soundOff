function songSelected(button){
    const songName = button.querySelector('.songName').textContent;
    const artistName = button.querySelector('.artistName').textContent;

    const data = {
        songName: songName,
        artistName: artistName,        
    }
    fetch('incrementScore.php', {
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
    
    location.reload();
}

function refresh(){
    location.reload();    
}