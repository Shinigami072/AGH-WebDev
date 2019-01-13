

function isCSS(link){
    return link.attributes["type"].value == "text/css" && link.attributes["title"] !== undefined
}
function changeCSSTO(i) {
    console.log(i)
    console.log(map[i])

    let links =document.getElementsByTagName('link');

    for (let j = 0; j < links.length; j++) {
        if(isCSS(links[j])){
            links[j].disabled=map[i].indexOf(j)<0;
        }
    }
    document.cookie="CSS="+i+";max-age=120";
    // alert(links[i])
    // links[i].disabled=false;
    // // links[i].attributes["disabled"]=undefined;
    // console.log(links[i].attributes)

}
map ={};
function getCookie(key){
    list = document.cookie;
    re = new RegExp(key+/=([^;]*)/)
    matches = re.exec(list);

    if(matches!==null)
        return matches[1];
    else
        return undefined;
}
function recreateList(){


    list = document.getElementById("styleList");
    map = {};
    //reset
    console.log(list);
    while (list.firstChild) {
        list.removeChild(list.firstChild);
    }
    console.log(list);
    let links =document.getElementsByTagName('link');
    console.log(links);

    for (let i = 0; i < links.length; i++) {
        if(isCSS(links[i])){
            let title = links[i].attributes["title"].value;
            if(map[title] == undefined){

                node1 = document.createElement("li");
                node2 = document.createElement("a");
                node1.appendChild(node2);
                node2.attributes["href"]="#";
                node2.onclick=function(){ changeCSSTO(title)};
                node2.innerText=(links[i].attributes["title"].value);
                list.appendChild(node1)
                console.log(node1);
                map[title]=[i]
                console.log(map)
            }
            else {
                map[title].push(i);
            }


        }
    }

    style = getCookie("CSS")
    if(style!==undefined)
        changeCSSTO(style);

}

function show(elem,h){
    if(h) {
        elem.hidden = true;
    }else {
        elem.removeAttribute("hidden");
    }
}
function statusChange(checkBox){
    let stat = !checkBox.checked;
    msgr = document.forms["msg"];
    show(msgr.elements["chat"],stat);
    show(msgr.elements["username"],stat);
    show(msgr.elements["msg"],stat);
}
function send(form){
    let messenge =form["msg"].value;
    let username=form["username"].value;
    console.log(form["msg"].value);
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "msg.php", true);
    xhttp.send({username:username,msg:messenge});
    xhttp.onreadystatechange = function () {
        console.log(xhttp);
    };
    form["msg"].value="";
    document.cookie="username="+form["username"].value+";max-age=120";


}
function messenger() {
    msgr = document.forms["msg"];
    msgr.elements["chat"].hidden=true;
    msgr.elements["username"].hidden=true;
    msgr.elements["msg"].hidden=true;

    let username = getCookie("username");
    if(username!==undefined)
        msgr.elements["username"].value=username;

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "read.php", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        console.log(xhttp)
        xhttp.send();
    }
}