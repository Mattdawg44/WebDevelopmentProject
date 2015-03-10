/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function init() {
    make_search_field("search_field", "Type car make, model, year, color, etc.");
    rented_cars("rented_cars", "rented_cars");
    rented_cars("returned_cars", "returned_cars");

}

function $(id){
    return document.getElementById(id);
}

function close_message() {
    $("background").style.display = "none";
    $("message_box").style.display = "none";
    $("message").innerHTML = "";
}

function show_message() {
    $("background").style.display = "block";
    $("message_box").style.display = "block";
}

function find_car() {
/* first prepare the data to be sent */
    var data = new FormData();
    data.append("search", $("search_field").value); //send the value of the search box
    $("find_car_loading").className="loading_visible";
     
    
    /* create an ajax object that will interact with the PHP server */
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { //this function is called whenever the status of the ajax request changes
        if (ajax.readyState === 4 && ajax.status === 200) { //if the request is processed and is received correctly
            //alert("result"+ajax.responseText);
            $("search_results").innerHTML = ajax.responseText; //go ahead and display the text returned by the server
            $("find_car_loading").className="loading_hidden"; 
        }
    };
    ajax.open("POST", "view_cars.php"); //specify the data to be sent via the POST method to view_ajax.php
    ajax.send(data); //send the data
}
//rented cars and rental history function
function rented_cars(type, id){
    
    var data = new FormData();
    
    
    data.append("type", type); //send the value of the search box
    var ajax = ajaxObject();

    ajax.onreadystatechange = function() { //this function is called whenever the status of the ajax request changes
        if (ajax.readyState === 4 && ajax.status === 200) { //if the request is processed and is received correctly
            $(id).innerHTML = ajax.responseText; //go ahead and display the text returned by the server
             
        }
    };
    
    
    ajax.open("POST", "view_cars.php"); //specify the data to be sent via the POST method to view_ajax.php
    ajax.send(data); //send the data
    
    
}

function logout(){
    var data = new FormData();
    data.append("type", "logout"); 
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            if(ajax.responseText.trim()=="success")
              window.location.assign("login.html");           
        }
    };
    ajax.open("POST", "logout.php"); 
    ajax.send(data); //send the data
}


