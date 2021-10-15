<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DisChat</title>
        
        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
            
            <!-- Custom CSS
            <link rel="stylesheet" href="css/custom.css">
-->
    <meta charset="UTF-8">
    <title>ChatRoom</title>
    <link type="text/css" rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<header id="pg-header">
    <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Second navbar example">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="index.php">Logout</a>
                    </li>
               
                        <?php
                            $email=$_GET['useremail'];
                            $name=$_GET['username'];
                            echo "<a class='nav-link' aria-current='page' id='name' >Welcome $name</a>";
                        ?>
                    <li>
                    </li>
                </ul>
            </div>
            
        </div>
        
    </nav>
</header>

    <div class="background">
        <h1>DisChat Chatroom</h1>

        <div class="display_field" id="messages">
            
        </div>
        <div class="input_div">
       
            <textarea class="input_field" id="input"></textarea>
            <button onclick="submitMessage()" class="sub_button" id="submit">Submit</button>
            <button onclick="refresh()" class="sub_button" id="submit">Refresh</button>

        </div>
    </div>
</body>
<script type="text/javascript">

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const name = urlParams.get('username');

const MonthLetter=["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];

function refresh(){
    location.reload();
}

function formattedDate(Stime) {

    var DateInfo = new Date(Stime);
    var date = DateInfo.getDate();
    var Month = DateInfo.getMonth(); // Be careful! January is 0, not 1
    var hour=DateInfo.getHours();
    var min=DateInfo.getMinutes();

    //return currentDayOfMonth + "-" + (currentMonth + 1) + "-" +"-"+hour;

    return hour+":"+min+"   "+MonthLetter[Month]+"-"+date;
    }






    async function submitMessage() {
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var name = urlParams.get('username');
        var message = document.getElementById("input").value;
        var topic="default";
        fetch( 'https://mhghrcl8oe.execute-api.us-east-1.amazonaws.com/prod/message',  {
			//fetch( 'https://b9xo3fh956.execute-api.us-east-1.amazonaws.com/prod/message',  {
            method: 'POST',
            body: JSON.stringify({
                "topic":topic,
                "name": name,
                "message": message
            })
		})
		.then(response => response.json())
		.then((response) => {
			console.log(response);
           // document.getElementById("messages").innerHTML += "<p>"+message+"</p>"; 
		});
        document.getElementById("input").innerHTML="";
        location.reload();
        
        
	}       





    
    async function getMessages() {
        var messages=[];
        fetch( 'https://mhghrcl8oe.execute-api.us-east-1.amazonaws.com/prod/message',  {
		//fetch( 'https://b9xo3fh956.execute-api.us-east-1.amazonaws.com/prod/message',  {
			method: 'GET'
		  })
			.then(response => response.json())
			.then((response) => {
                  
                console.log(response.body);
                response.body.forEach(element => {
                    var today=formattedDate(element.time);
                    var message={
                        "time":element.time,
                        "content":element.message,
                        "name":element.name
                        }
                    messages.push(message);
                                      
                                    
                });
                  messages.sort(function (a, b) {
                    return a.time - b.time;
                  });
                
                  for(i=0;i<messages.length;i++){
                        
                  if(messages[i].name==name){
                  var today=formattedDate(messages[i].time);
                  document.getElementById("messages").innerHTML +='<p class="rightmsg">'+ messages[i].name+"  "+today +'</p><div class="rightmsg"><span>' +messages[i].content+ '</span></div>';
                  }else{                  
                  var today=formattedDate(messages[i].time);
                  document.getElementById("messages").innerHTML +='<p>'+ messages[i].name+"  "+today +'</p><div class="leftmsg"><span>' +messages[i].content+ '</span></div>';
                  }
                  }
			});
        
       
        
        
        }

getMessages();



        
 
    
  
    
</script>
</html>

