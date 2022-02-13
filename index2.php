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
        <a href=funychat/info.html target=_blank> Information </a><br><br><select onchange=theme() class=select id=select><option value=dark.css> dark theme </option><option value=light.css> light theme </option><option value=test.css> test theme </option></select><br>
        <br>
        <p id=name5>Name: UNNAMED</p>
        <p id=room5> Room: None </p>
        <p id=status5 style="color: orange;"> Status: Connecting... </p>
<p id=usercount>User Count: getting...</p><br><div id=namelist><h3>user list</h3></div></div></div></div><div id=namediv><div id=nameform><form action="javascript:showeverything()"><h1 style="font-size:35px;"> Join a room </h1><h3> nickname </h3><input id=nameput required><br><h3> Room (optional)</h3> <input id=room> <br><br><font size=4 ><b><a href="javascript:cserver()"> Custom Server </a></b></font><br><br><input type=submit id=namesub value="join"></form></div>
</div>
<script>
var ws;
var kickedeg = 0;
var server = "wss://funychat-3.funyegg.repl.co/";
function cserver(){
    server2 = prompt("url");
    if (server2!==null){
        server = server2;
    }
}
    function showeverything(){
if( document.getElementById("nameput").value.length <= 50){
document.getElementById("name5").innerHTML =  document.getElementById("nameput").value
}else{
document.getElementById("name5").innerHTML = "Name: can you not";
}
ws = new WebSocket(server);
ws.onopen = ()=>{

ws.send("name:" + document.getElementById("nameput").value);
document.getElementById("status5").style.color = "green";
document.getElementById("status5").innerHTML = "Status: Connected";

    if (document.getElementById("room").value == ''){
document.getElementById("room5").innerHTML = 'Room: main';
ws.send('room:main');
    }else{
        if( document.getElementById("room").value.length > 50){
document.getElementById("room5").innerHTML = 'Room: comedy lmfao';
        }else{
document.getElementById("room5").innerHTML = 'Room: '+ document.getElementById("room").value.replaceAll("<","&lt").replaceAll(">","&gt");
}
ws.send("room:" + document.getElementById("room").value);
}
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
    if (data.data.substring(0,6)=="count:"){
document.getElementById("usercount").innerHTML = "User Count: " + data.data.replace("count:","");
    }else if(data.data.substring(0,6)=="names:"){
      document.getElementById("namelist").innerHTML = "<h3>user list</h3>"  + data.data.replace("names:","").replaceAll(",","<br><br>").replaceAll("&SCM",",");
        } else if(data.data == 
"kicked"){

            kickedeg = 1;
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




}


function send(){
    
    if (document.getElementById("sendeg").value !== ""){
    ws.send(document.getElementById("sendeg").value);
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