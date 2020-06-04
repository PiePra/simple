//get OnlineStatus Window
const OnlineStatus = document.querySelector('#OnlineStatus');
//get Chat Window 
const ChatWindow = document.querySelector('#ChatWindow');

//load all Functions after document loaded
function loadAll() {
    loadOnline();
    loadChat();
    periodicChat();
    periodicOnline();  
}

//request json return from getOnline.php
function loadOnline () {
    const req = new XMLHttpRequest();
    req.open("get", "getOnline.php");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        //populate Online Status Window
        populateOnline(json);
    };
    req.send();
}

//request json return from getMessages.php
function loadChat () {
    const req = new XMLHttpRequest();

    req.open("get", "getMessage.php");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        //populate Messages Window
        populateChat(json);
    };
    req.send();
}


function populateOnline(json){
    //purge existing elements
    while (OnlineStatus.firstChild){
        OnlineStatus.removeChild(OnlineStatus.firstChild);
    }
    //populate with new elements
    json.forEach((row) => {
        //add every returned Online User
        const li = document.createElement("li")
        li.textContent = row.nutzername;
        //change color based on the given Code
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
    //purge existing elements
    while (ChatWindow.firstChild){
        ChatWindow.removeChild(ChatWindow.firstChild);
    }
    //populate with new elements
    json.forEach( (chat) => {
        //add every returned Messages author, timestamp and messagetext
        const row = document.createElement("div");
        //add bootstrap classes
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

//asynchronous messages reload every 3 seconds
async function periodicChat(){
    while(true){
        await new Promise(resolve=> {
            setTimeout(() => { resolve(loadChat());
             }, 3000);
        });
    }

}

//asynchronous online status reload every 5 seconds
async function periodicOnline(){
    while(true){
        await new Promise(resolve=> {
            setTimeout(() => { resolve(loadOnline());
             }, 5000);
        });
    }

}

//load js after document loaded
document.addEventListener("DOMContentLoaded", () => {loadAll(); });