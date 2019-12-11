<?php
namespace API;
include_once 'APIBase.php';
include_once '../Data/Repository.php';
use API;
use Data\Repository;
class Product extends API\APIBase{

    function Get(){      
        $repository = new Repository\Product();
        $this->Response->Result = $repository->GetAllProducts();
    }

    function GetWith($req) {
        //validate request
        if(!isset($req->ID) || empty($req->ID)){
            $this->AddValidationMessage("Product ID is Required");
            $this->SendResponse(200);
        }

        //get result
        $repository = new Repository\Product();
        $this->Response->Result = $repository->GetProduct($req->ID);
    }

    function Post($req){
        //validate request
        if(empty($req->Name)) $this->AddValidationMessage("Name is Required");
        
        if(empty($req->Description)) $this->AddValidationMessage("Description is Required");
        
        if(!isset($req->Price)) $this->AddValidationMessage("Price is Required");

        if(count($this->Response->ValidationMessages) > 0){
            $this->SendResponse(200);
        }
        
        //get result
        $repository = new Repository\Product();
        $this->Response->Key = $repository->Insert($req);
    }

    function Put($req){
        //validate request
        if(empty($req->ID)) $this->AddValidationMessage("ID is Required");

        if(empty($req->Name)) $this->AddValidationMessage("Name is Required");
        
        if(empty($req->Description)) $this->AddValidationMessage("Description is Required");
        
        if(!isset($req->Price)) $this->AddValidationMessage("Price is Required");

        if(count($this->Response->ValidationMessages) > 0){
            $this->SendResponse(200);
        }
        //get result
        $repository = new Repository\Product();
        array_push($this->Response->Result, $repository->Update($req));
    }
}
new Product();
?>