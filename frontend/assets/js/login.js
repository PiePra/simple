document.getElementById('myForm').onsubmit = function () {
    let muser = document.getElementById('muser');
    let errorMsg = document.getElementById('errorMsg');
    
    console.log('Formular wird ausgefüllt');
    if ( muser.value == '') {
        errorMsg.innerHTML = 'Feld ist erforderlich';
        muser.focus();
        return false;
    }
}

const userLogin = async () => {
    const response = await fetch('./backend/login.php', {
        method: 'POST',
        body: user,
        headers: {
            'Content-Type' : 'application/json'
        }
    });
    const myJson = await response.json(); //extract JSON from the http response
    // do something with myJson
    console.log(myJson);
  }