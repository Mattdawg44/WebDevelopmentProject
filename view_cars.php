<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'connection.php';
$car = "";
if (isset($_POST['search']) && trim($_POST['search']) != "") {
    $data = $_POST['search'];
    /* select all students whose first names or last names contain the text the user has entered */
    $query = "SELECT * FROM carspecs INNER JOIN car ON carspecs.ID = car.CarSpecsID WHERE Color LIKE '%$data%' OR Model LIKE '%$data%' OR Year LIKE '%$data%' OR Size LIKE '%$data%' ";
    $result = mysql_query($query);

    if (!$result)
        die("Database access failed: " . mysql_error());

    $row_count = mysql_num_rows($result);

    for ($j = 0; $j < $row_count; ++$j) {

        $row = mysql_fetch_array($result); //fetch the next row
        $car.=display_car($row);
    }
    
    echo $car;
    
    mysql_close($db_server);
}

function display_car($row) {
    $car = "";
    //$car.="<div onclick='sort_by_button' class=''>";      this is for the sort but it has no class or function
    $car.="<div class='search_item'>";
    $car.='<img src="data:' . $row["picture_type"] . ';base64,' . base64_encode($row["picture"]) . '">';
    $car.="<div class='car_make_background'>";
    $car.="<div class='car_make'> " . $row["Make"]." </div>";
    $car.="<div class='car_model'> " . $row["Model"] . " | ".$row["Year"]."</div>" ;
    $car.="</div>";
           
    $car.="<div class='car_size'> Size: " . $row["Size"]." </div>";
    $car.="<div class='car_color'> Color: " . $row["Color"]." </div>";
    $car.="<div onclick='rent_car(this)' class='car_rent' id='" . $row["ID"] . "'> Rent Car</div>";
    
    $car.="</div>";
    return $car;
}
//connects with ajax to help show what has been rented and rental history
//data for rented cars and rented history 
$text="";
if (isset($_POST['type']) && is_session_active()) {

        $type = sanitizeMYSQL($_POST['type']);
            
        switch ($type) {
                case "rented_cars":
                    
                        $query = "SELECT * "
                                . "FROM carspecs "
                                . "inner join car "
                                . "ON carspecs.ID = car.carspecsID "
                                . "inner join rental "
                                . "ON car.ID = rental.carID "
                                . "inner join customer "
                                . "ON rental.customerID = customer.ID "
                                . "Where rental.customerID = '" . $_SESSION["username"] . "'";
            
                        $result = mysql_query($query);
                        $text = "";
                        if (!$result)
                            $text = "No results were found";
                        else {
                                $row_count = mysql_num_rows($result);
                
                                for ($i = 0; $i < $row_count; $i++) {
                    
                                    $row = mysql_fetch_array($result);
                                    $text.= display_rented_car($row);
                                }
                            }
                        echo $text;
                        break;
                        
                case "returned_cars":
                    
                        $query = "SELECT * "
                                . "FROM carspecs "
                                . "inner join car "
                                . "ON carspecs.ID = car.carspecsID "
                                . "inner join rental "
                                . "ON car.ID = rental.carID "
                                . "inner join customer "
                                . "ON rental.customerID = customer.ID "
                                . "Where rental.customerID = '" . $_SESSION["username"] . "' "
                                . "and rental.rentDate != '' and rental.returnDate != ''";
            
                        $result = mysql_query($query);
                        $text = "";
                        if (!$result)
                            $text = "No results were found";
                        else {
                                $row_count = mysql_num_rows($result);
                
                                for ($i = 0; $i < $row_count; $i++) {
                    
                                    $row = mysql_fetch_array($result);
                                    $text.= display_rented_car($row);
                                }
                            }
                        echo $text;
                        break;
            
                        }
}
$text="";
function display_rented_car($row) {
    $text = "";
    $text.="<div class='car_details'>";
    $text.='<img src="data:' . $row["picture_type"] . ';base64,' . base64_encode($row["picture"]) . '">';
    $text.="<div class='car_make'>" . $row["Make"]." </div>";
    
//    $text .= "<div class='car_picture'>";
//    
//    $text .= "<table border = '1'>";
//    
//    $text .= "<tr>";
//    $text .= "<td rowspan = '4'>";
//    $text .= '<img src="data:' . $row["picture_type"] . ';base64,' . base64_encode($row["picture"]) . '">';
//    $text .= "</td>";
//    $text .= "<td>";
//    $text .= $row["Make"];
//    $text .= "</td>";
//    $text .= "</tr>";
    
//    $car_info .= "<tr>";
//    $car_info .= "<td>";
//    $car_info .= $row["Model"] . " | " . $row["Year"];
//    $car_info .= "</td>";
//    $car_info .= "</tr>";
//   
//    $car_info .= "<tr>";
//    $car_info .= "<td>";
//    $car_info .= "Size: " . $row["Size"];
//    $car_info .= "</td>";
//    $car_info .= "</tr>";
//    
//    $car_info .= "<tr>";
//    $car_info .= "<td>";
//    $car_info .= "Color: " . $row["Color"];
//    $car_info .= "</td>";
//    $car_info .= "</tr>";
//    
//    $car_info .= "</table>";
//    
//    $car_info .= "</div>";
    
    return $text;
    
}
//    $car.="<div class='search_item'>";
//    $car.='<img src="data:' . $row["picture_type"] . ';base64,' . base64_encode($row["picture"]) . '">';
//    $car.="<div class='car_make_background'>";
//    $car.="<div class='car_make'> " . $row["Make"]." </div>";
//    $car.="<div class='car_model'> " . $row["Model"] . " | ".$row["Year"]."</div>" ;
//    $car.="</div>";
//           
//    $car.="<div class='car_size'> Size: " . $row["Size"]." </div>";
//    $car.="<div class='car_color'> Color: " . $row["Color"]." </div>";
//    $car.="<div onclick='rent_car(this)' class='car_rent' id='" . $row["ID"] . "'> Rent Car</div>";
//    
//    $car.="</div>";
//    return $car;
?>
