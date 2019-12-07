function ResponseModel(result = [], validationMessages = []){
    this.Result = result;
    this.ValidationMessages = validationMessages;
    this.Key;
    this.IsValid = function(){
        let isValid = false;
        if (!this.ValidationMessages || this.ValidationMessages.length == 0)
        isValid = true;
        return isValid;
    }
}

var Data = {
    BaseURL: "\\_API\\Controllers\\",
    ContentType: "application/json",
    Get: (controller, params = '') => {
        return Data._ReqWithURI('GET',controller,params)
    },
    Post:(controller, params) => {
        return Data._ReqWithBody('POST',controller,params)
    },
    Put:(controller, params) => {
        return Data._ReqWithBody('PUT',controller,params)
    },
    Delete: (controller, id) => {
        return Data._ReqWithURI('DELETE',controller,`id=${id}`)
    },
    _ReqWithBody: (verb, controller, params) => {
        let promise = new Promise((resolve, reject) => {
            let req = new XMLHttpRequest;
            req.open(verb,`${Data.BaseURL}${controller}.php`,true);
            req.setRequestHeader("Content-Type", Data.ContentType);
            req.onreadystatechange = (event) => {
                let res = event.currentTarget;
                if(res.readyState == 4 && res.status == 200){
                    try{
                        resolve(Data._MapResponse(res));
                    }catch(err){
                        reject(Data._MapError(res, err));
                    }
                }else if (res.readyState == 4 && res.status != 200){
                    reject(event);
                }
            }
            let paramsJson = JSON.stringify(params);
            req.send(paramsJson);
        })
        return promise;
    },
    _ReqWithURI: (verb, controller, queryParams) => {
        let promise = new Promise((resolve, reject) => {
            let req = new XMLHttpRequest;
            req.open(verb,`${Data.BaseURL}${controller}.php?${queryParams}`,true);
            req.setRequestHeader("Content-type", Data.ContentType);
            req.onreadystatechange = (event) => {
                let res = event.currentTarget;
                if(res.readyState == 4 && res.status == 200){
                    try{
                        resolve(Data._MapResponse(res));
                    }catch(err){
                        reject(Data._MapError(res, err));
                    }
                }else if (res.readyState == 4 && res.status != 200){
                    reject(event);
                }
            }
            req.send();
        })
        return promise;
    },
    _MapResponse: (res) =>{
        let response = JSON.parse(res.responseText);
        return new ResponseModel(response.Result, response.ValidationMessages)
    },
    _MapError:(res, err)=>{
        let response = new ResponseModel;
        response.ValidationMessages.push(res.responseText);
        response.ValidationMessages.push(err);
        console.log(response);
        return response;
    }
}