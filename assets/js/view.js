const online_status = document.querySelector('#online-status');

function loadOnline () {
    const req = new XMLHttpRequest();

    req.open("get", "../test/online.json");
    req.onload = () => {
        const json = JSON.parse(req.responseText);
        populateOnline(json);
    };
    req.send();
}


function populateOnline(json){
    //purge
    while (online_status.firstChild){
        online_status.removeChild(online_status.firstChild);
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

        online_status.appendChild(li);
    });
}

document.addEventListener("DOMContentLoaded", () => {loadOnline(); });