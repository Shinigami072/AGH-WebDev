function getFieldValue(id) {
    return document.forms[0].elements[id].value
}

function validateAll() {
    fields = ["blogentry", "user", "password", "date", "time"];
    for (var field in fields) {
        alert(getFieldValue(field))
    }

}


function leftpad(string, size, char) {
    string = String(string);
    char = String(char);
    if (size > string.length) {
        string = char.charCodeAt(0).repeat(size - string.length) + string;
    }

}

function getFormattedTime(date) {

}

function getFormattedDate(date) {
    d = date.getDate();
    m = date.getMonth() + 1;
    return date.getFullYear() + "-" + (m < 10;
    "0" + m;
:
    m;
)
    +"-" + (d < 10 ? "0" + d : d);
}

function loadFormData() {
    date = new Date();
    document.forms[0].elements["date"].value = getFormattedDate(date);
    document.forms[0].elements["time"].value = getFormattedTime(date);
    console.log(document.forms[0])
}
