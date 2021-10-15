
//document.getElementById("messages").innerHTML += "<p> script load</p>";

//console.log("script load");
//const salt = "663befc1-151c-4403-b3b3-321f4d25ed77";

async function getLoginAPI(){
        fetch( 'https://p6fp2njy9f.execute-api.us-east-1.amazonaws.com/product/',  {
            method: 'GET'
          })
            .then(response => response.json())
            .then((response) => {
                document.getElementById("messages").innerHTML +="<input type='hidden' id='loginAPI' value='"+response+"'/>";
                return response;
            });
}

async function getSaltAPI(){
        fetch( 'https://awhd7scd4c.execute-api.us-east-1.amazonaws.com/product/',  {
            method: 'GET'
          })
            .then(response => response.json())
            .then((response) => {
                document.getElementById("messages").innerHTML +="<input type='hidden' id='saltValue' value='"+response+"'/>";
                return response;
            });
}
getSaltAPI();


async function getCreateAPI(){
        fetch( 'https://nxuhvh1ehe.execute-api.us-east-1.amazonaws.com/product/',  {
            method: 'GET'
          })
            .then(response => response.json())
            .then((response) => {
                document.getElementById("messages").innerHTML +="<input type='hidden' id='CreateUserAPI' value='"+response+"'/>";
                return response;
            });
}
getLoginAPI();
getCreateAPI();

async function createuser() {
    var salt=document.getElementById('saltValue').value;
    var name = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    
    var dbpassword = CryptoJS.MD5(password + salt).toString();
    var url=document.getElementById('CreateUserAPI').value;
 
    fetch( url,  {
    method: 'POST',
    body: JSON.stringify({
        "name": name,
        "email": email,
        "password": dbpassword
    })
    })
    .then(response => response.json())
    .then((response) => {
        console.log(response.body);
        document.getElementById("messages").innerHTML += "<p>"+response.body+"</p>";
        var userInfo="username="+name+"&useremail="+email;
        url="./chatroom.php?"+userInfo;

        window.open(url,"_self");
        
    });
}

async function login() {
    //document.getElementById("messages").innerHTML +=document.getElementById('loginAPI').value;
    var salt=document.getElementById('saltValue').value;
    var url=document.getElementById('loginAPI').value;
    
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var dbpassword = CryptoJS.MD5(password + salt).toString();
    //document.getElementById("messages").innerHTML +=dbpassword;
    
    fetch( url,  {
    method: 'POST',
    body: JSON.stringify({
        "email": email,
        "password": dbpassword
    })
    })
    .then(response => response.json())
    .then((response) => {
        console.log(response.body);
        response.body.forEach(element => {
            if (element.condition==0){
                document.getElementById("messages").innerHTML = "<p> Email or Password incorrect "+element.condition+"</p>";
                document.getElementById("password").value ='';
                url="./index.php?message=Email_or_Password_incorrect";

                window.open(url,"_self");
            }else if (element.condition==1){
                var userInfo="username="+element.name+"&useremail="+email;
               // document.getElementById("messages").innerHTML += "<p> Welcome "+element.name+"</p>";
                url="./chatroom.php?"+userInfo;
     
                window.open(url,"_self");

                
            }
            
            
        });
    });
    
    return 0;
}






