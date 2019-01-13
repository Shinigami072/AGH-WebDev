function getFieldValue(id) {
    return document.forms[0].elements[id].value
}
let fileCount =0;


function validateAll() {
    let fields = ["blogentry", "user", "password"];
    for (var field in fields) {
        var val=getFieldValue(fields[field]);
        if(val ===null || val.length===0){
            alert("nie wypołniono odpowiedniego pola ("+fields[field]+")");
            return false;
        }
    }
    setDate();
    return true;

}
function addFiles(file) {
    parent = file.parentNode;

    if(file.files !== undefined && parent.lastElementChild.id ===file.id){
        fileCount=parseInt(file.id.substring(5))+1;
        let node = document.createElement("input");
        node.type="file";
        node.name="files["+fileCount+"]";
        node.id="files"+fileCount;
        node.onchange=function(){addFiles(node)};
        parent.appendChild(node);
    }
}

function  setDate() {
    var re = /([1-9][0-9]{3})-(1[0-2]|0[1-9])-(3[10]|[12][0-9]|0[1-9])/;
    var date =  document.forms[0].elements["date"].value;
    var matches = re.exec(date);
    var parsedDate = new Date(date);

    if(matches!== null&&Boolean(+parsedDate) && parsedDate.getDate() === parseInt(matches[3])){
        return;
    }
    if(matches!== null) {
        console.log(matches);
        console.log(Boolean(+parsedDate) && parsedDate.getDate() === parseInt(matches[3]));
        console.log(parsedDate.getDate() === parseInt(matches[3]));
        console.log(Boolean(+parsedDate));
    }
    date = new Date();
    document.forms[0].elements["date"].value = getFormattedDate(date);
    document.forms[0].elements["time"].value = getFormattedTime(date);

}
function getFormattedTime(date) {
    h = date.getHours();
    m = date.getMinutes();
    return (h < 10?
        "0" + h: h) + ":" + (m < 10?
        "0" + m: m);
}

function getFormattedDate(date) {
    d = date.getDate();
    m = date.getMonth() + 1;
    return date.getFullYear() + "-" + (m < 10?
    "0" + m: m)
    +"-" + (d < 10 ? "0" + d : d);
}
function reset(){
    document.forms[0].reset();
    loadFormData();

}
function loadFormData() {
    setDate();
}
