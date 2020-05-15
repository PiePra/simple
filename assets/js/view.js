const OnlineStatus = document.querySelector('#OnlineStatus');
const ChatWindow = document.querySelector('#ChatWindow');
const Title = document.querySelector('#Title');

function loadAll() {
    loadOnline();
    loadChat();
}

//load online.json
function loadOnline () {
    const req = new XMLHttpRequest();
    req.open("get", "../test/online.json");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        populateOnline(json);
    };
    req.send();
}

//load chat.json
function loadChat () {
    const req = new XMLHttpRequest();

    req.open("get", "../test/chat.json");
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
        li.textContent = row.name;
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
    Title.textContent = json.group;
    while (ChatWindow.firstChild){
        ChatWindow.removeChild(ChatWindow.firstChild);
    }

    json.chats.forEach( (chat) => {
        const row = document.createElement("div");
        row.classList.add("row")
        const author = document.createElement("div");
        author.classList.add("col-2", "w-100", "mx-2");
        const time = document.createElement("div");
        time.classList.add("col-3", "w-100", "mx-2");
        const message = document.createElement("div");
        message.classList.add("col-6", "w-100", "mx-2");
        const p1 = document.createElement("p");
        p1.textContent = chat.message;
        message.appendChild(p1)
        const p2 = document.createElement("p");
        p2.textContent = chat.time;
        time.appendChild(p2);
        const p3 = document.createElement("p");
        p3.textContent = chat.author;
        author.appendChild(p3)
        row.appendChild(time);
        row.appendChild(author);
        row.appendChild(message);
        ChatWindow.appendChild(row);
    });


}


document.addEventListener("DOMContentLoaded", () => {loadAll(); });