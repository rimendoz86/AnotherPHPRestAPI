<?php 
namespace Data\Repository;
include 'Connection.php';
use Data;

class Product extends Data\Connection{

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
        WHERE IsActive = 1 AND ID = ?;";

        return $this->dbSelect($sql, "i",[$id]);
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
            ?,
            ?,
            ?
        )";
        $params = [$req->Name,$req->Description,$req->Price];
        return $this->dbInsert($sql, "ssi", $params);
    }

    function Update($req){
        $sql = "UPDATE Product SET
        Name = ?,
        Description = ?,
        Price = ?
        WHERE ID = ?;";

        $params = [$req->Name,$req->Description, $req->Price, $req->ID];
        $this->dbUpdate($sql,"ssii", $params);
        return $req;
    }

}
?>