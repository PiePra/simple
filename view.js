const OnlineStatus = document.querySelector('#OnlineStatus');
const ChatWindow = document.querySelector('#ChatWindow');

function loadAll() {
    loadOnline();
    loadChat();
    periodicChat();
    periodicOnline();  
}

//load online.json
function loadOnline () {
    const req = new XMLHttpRequest();
    req.open("get", "getOnline.php");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        populateOnline(json);
    };
    req.send();
}

//load chat.json
function loadChat () {
    const req = new XMLHttpRequest();

    req.open("get", "getMessage.php");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        populateChat(json);
    };
    req.send();
}


function populateOnline(json){
    //purge
    while (OnlineStatus.firstChild){
        OnlineStatus.removeChild(OnlineStatus.firstChild);
    }
    //populate
    json.forEach((row) => {
        const li = document.createElement("li")
        li.textContent = row.nutzername;
        switch(row.status){
            case 0:
                li.style.color = "green"; 
                break;
            case 1:
                li.style.color = "orange"; 
                break;
            case 2: 
                li.style.color = "grey";
                break;
            default: break;     
        }

        OnlineStatus.appendChild(li);
    });
}


function populateChat(json){
    //Title.textContent = json.group;
    while (ChatWindow.firstChild){
        ChatWindow.removeChild(ChatWindow.firstChild);
    }

    json.forEach( (chat) => {
        const row = document.createElement("div");
        row.classList.add("row")
        const author = document.createElement("div");
        author.classList.add("col-2", "w-100", "mx-2");
        const time = document.createElement("div");
        time.classList.add("col-3", "w-100", "mx-2");
        const message = document.createElement("div");
        message.classList.add("col-11", "w-100", "mx-2");
        const p1 = document.createElement("p");
        p1.textContent = chat.message;
        message.appendChild(p1)
        const p2 = document.createElement("p");
        p2.textContent = chat.time;
        p2.style.color = "blue";
        time.appendChild(p2);
        const p3 = document.createElement("p");
        p3.style.color = "blue";
        p3.textContent = chat.author;
        author.appendChild(p3)
        row.appendChild(time);
        row.appendChild(author);
        row.appendChild(message);
        ChatWindow.appendChild(row);
    });
}


async function periodicChat(){
    while(true){
        await new Promise(resolve=> {
            setTimeout(() => { resolve(loadChat());
             }, 3000);
        });
    }

}

async function periodicOnline(){
    while(true){
        await new Promise(resolve=> {
            setTimeout(() => { resolve(loadOnline());
             }, 5000);
        });
    }

}


document.addEventListener("DOMContentLoaded", () => {loadAll(); });