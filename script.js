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
        return new Data._Response(response.Result, response.ValidationMessages, response.Key);
    },
    _MapError:(res, err)=>{
        let response = new Data._Response;
        response.ValidationMessages.push(res);
        response.ValidationMessages.push(err);
        console.log(response);
        return response;
    },
    _Response: function (result = [], validationMessages = [], key = null){
        this.Result = result;
        this.ValidationMessages = validationMessages;
        this.Key = key;
        this.IsValid = function(){
            return !this.ValidationMessages || this.ValidationMessages.length == 0
        }
    }
}