<?php 
namespace Data\Repository;
include 'Connection.php';
use Data;

class Product extends Data\Connection{
    //This was for a school project, 
    //you should use parameter binding where applicable, 
    //maybe future version will have binding as a part of the methods
    function GetAllProducts(){
        $sql = "
        SELECT ID, Name, Description, Price  
        FROM Product
        WHERE IsActive = 1;";

        return $this->dbSelect($sql);
    }

    function GetProduct($id){
        $sql = "SELECT ID, Name, Description, Price  
        FROM Product
        WHERE IsActive = 1 AND ID = $id;";

        return $this->dbSelect($sql);
    }

    function Insert($req){
        $sql = "INSERT INTO Product
        (
            Name, 
            Description,
            Price
        )
        VALUES
        (
            '$req->Name',
            '$req->Description',
            $req->Price
        )";
        return $this->dbInsert($sql);
    }

    function Update($req){
        $sql = "UPDATE Product SET
        Name = '$req->Name',
        Description = '$req->Description',
        Price = $req->Price
        WHERE ID = $req->ID;";

        $this->dbUpdate($sql);
        return $req;
    }

}
?>