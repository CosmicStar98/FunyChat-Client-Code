<head>
<title> Funychat</title>
<style>
.select{
    padding: 2px;
    border-style:solid;
    border-color:#202020;
    border-width:5px;
    font-size: 15px;
    outline:none;
    color: white;
    background-color: #202020;
}
option:hover{
    background-color:#404040;
}
img{
    max-width:400px;
    max-height:400px;
}
video{

    max-width:500px;
    max-height:500px;
}
</style>
<link id=stylesheet rel=stylesheet href='themes/dark.css'>
</head>

<div class=chatdiv id=chatdiv style="display: none"><div class=testeg2 id=testeg2><div id=testeg class=testeg ></div></div><form action="javascript:send()"><input class=msgin autocomplete=off id=sendeg><br><br> <input type=submit class=msgbtn value=send></form>
<div class=stats>
    <div style="padding: 0px 5px">
        <h2 style="font-size: 22px;"> Funychat</h2>
        <a href="http://eggyprojects.ml"> Home Page </a><br>
        <a href=./info.php target=_blank> Information </a><br><br><select onchange=theme() class=select id=select><option value=dark.css> dark theme </option><option value=light.css> light theme </option><option value=test.css> test theme </option></select><br>
        <br>
        <p id=name5>Name: UNNAMED</p>
        <p id=room5> Room: None </p>
        <p id=status5 style="color: orange;"> Status: Connecting... </p>
<p id=usercount>User Count: getting...</p><br><div id=namelist><h3>user list</h3></div></div></div></div><div id=namediv><div id=nameform><form action="javascript:showeverything()"><h1 style="font-size:35px;"> Join a room </h1><h3> nickname </h3><input id=nameput required><br><h3> Room (optional)</h3> <input id=room> <br><br><font size=4 ><b><a href="javascript:cserver()"> Custom Server </a></b></font><br><br><input type=submit id=namesub value="join"></form></div>
</div>
<script>
var ws;
var kickedeg = 0;
var server = "wss://chat-with-rooms.colinkrzemienow.repl.co";
function cserver(){
    server2 = prompt("url");
    if (server2!==null){
        server = server2;
    }
}
    function showeverything(){

if (document.getElementById("nameput").value.length < 51){
document.getElementById("name5").innerHTML = "Name: " + document.getElementById("nameput").value.replaceAll('room:','').replaceAll('name:','');
ws = new WebSocket(server);
ws.onopen = ()=>{
    if (document.getElementById("room").value == ''){
document.getElementById("room5").innerHTML = 'Room: main';
ws.send('room:main');
    }else{
        if (document.getElementById("room").value.length <= 50){
document.getElementById("room5").innerHTML = 'Room: '+ document.getElementById("room").value.replaceAll("<","&lt").replaceAll(">","&gt");
} else{
    document.getElementById("room5").innerHTML = 'Room: 50 characters is the limit';
}
ws.send("room:" + document.getElementById("room").value);
}
ws.send("name:" + document.getElementById("nameput").value.replaceAll('room:','').replaceAll('name:',''));
document.getElementById("status5").style.color = "green";
document.getElementById("status5").innerHTML = "Status: Connected";
}
ws.onclose = ()=>{
if (kickedeg == 0){

document.getElementById("status5").style.color = "red";
    document.getElementById("testeg").innerHTML += "<p style='color:red;'>cannot connect to server. retrying in 10 seconds</p>";
    document.getElementById("testeg").scrollTop = document.getElementById("testeg").scrollHeight;

    document.getElementById("testeg2").scrollTop = document.getElementById("testeg2").scrollHeight;
document.getElementById("status5").innerHTML = "Status: Disconnected";
} else{

document.getElementById("status5").style.color = "#AA0000";
        document.getElementById("testeg").innerHTML += "<p style='color:red;'>Client: cannot connect to server because you got kicked.</p>";
    document.getElementById("testeg").scrollTop = document.getElementById("testeg").scrollHeight;

    document.getElementById("testeg2").scrollTop = document.getElementById("testeg2").scrollHeight;
document.getElementById("status5").innerHTML = "Status: Disconnected (Kicked)";
}
setTimeout(function(){
if (kickedeg == 0){
    document.getElementById("testeg").innerHTML += "<p style='color:orange;'>retrying...</p>";
    document.getElementById("testeg2").scrollTop = document.getElementById("testeg2").scrollHeight;
    document.getElementById("testeg").scrollTop = document.getElementById("testeg").scrollHeight;
    showeverything();
}
},10000)
}


document.getElementById("namediv").style.display = "none";
        document.getElementById("chatdiv").style.display = "block";
ws.onmessage = data=>{
    if (data.data.includes("count:")){
document.getElementById("usercount").innerHTML = "User Count: " + data.data.replace("count:","");
    }else if(data.data.includes("names:")){
      document.getElementById("namelist").innerHTML = "<h3>user list</h3>"  + data.data.replace("names:","").replaceAll("<br>","<br><br>");
        } else if(data.data == 
"kicked"){

            kickedeg = 1;
            }else if(data.data == '<p style="color:gray;">Server: invalid room </p>'){
                document.getElementById("room5").innerHTML = 'Room: INVALID, please <a href="">refresh and retry</a>';

    document.getElementById("testeg").innerHTML += "<p>"+ data.data + "</p>";
    document.getElementById("testeg").scrollTop = document.getElementById("testeg").scrollHeight;
    document.getElementById("testeg2").scrollTop = document.getElementById("testeg2").scrollHeight;
                } else if(data.data == '%CT$homepage'){
                    setTimeout(function(){
location.reload();
                    },1000)
                    }else{
    document.getElementById("testeg").innerHTML += "<p>"+ data.data + "</p>";
    document.getElementById("testeg").scrollTop = document.getElementById("testeg").scrollHeight;
    document.getElementById("testeg2").scrollTop = document.getElementById("testeg2").scrollHeight;
    }
}



} else{
    alert("max name length is 50 characters!")
}
}


function send(){
    
    if (document.getElementById("sendeg").value !== ""){
    ws.send(document.getElementById("sendeg").value.replaceAll("name:","name").replaceAll("room:","room").replaceAll('names:','names'));
    document.getElementById("sendeg").value = "";
    }
}



function theme(){
if (document.getElementById('select').value == 'light.css'){
document.getElementById('select').style.color = 'black';
document.getElementById('select').style.backgroundColor = "#eeeeee";

document.getElementById('select').style.borderColor = "#eeeeee";

document.getElementById('stylesheet').href = 'themes/light.css';
} else if (document.getElementById('select').value == 'dark.css'){

document.getElementById('select').style.color = 'white';
document.getElementById('select').style.backgroundColor = "#202020";

document.getElementById('select').style.borderColor = "#202020";

document.getElementById('stylesheet').href = 'themes/dark.css';
} else{

document.getElementById('stylesheet').href = 'themes/'+document.getElementById('select').value;
}
}
    </script>
