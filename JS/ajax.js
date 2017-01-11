angular.module('routeApp').factory('Ajax', function($http, $location, $sce) {
    var controller = "Ajax";
    return {
        csrfToken: "",
        csrf: function () {
            return $http.post(APP , {controller: "CSRF"});
        },
        contact: function (text) {
          return $http.post(APP , {text : text, action: "SENDCONTACT", controller: controller, csrf: this.csrfToken});
        },
        getHome: function (text) {
          return $http.post(APP , {action: "GETHOME", controller: controller, csrf: this.csrfToken});
        },
        checkUser: function (text) {
            console.log(this);
          return $http.post(APP , {action: "CHECKUSER", controller: controller, csrf: this.csrfToken});
        },
        disconnect: function () {
          return $http.post(APP , {action: "DISCONNECT", controller: controller, csrf: this.csrfToken}).then(function (promise) {
              $location.path('login');
          });
        },
        login: function (log, psw) {
          return $http.post(APP , {login : log, password: psw, action: "LOGIN", controller: controller, csrf: this.csrfToken});
        },
        register: function (log, psw) {
          return $http.post(APP , {login : log, password: psw, action: "REGISTER", controller: controller, csrf: this.csrfToken});
        }
    }
}).factory('Upload', function($http, $location, $sce) {
    var controller = "Ajax";
    return {
        csrfToken: "",
        test: function (vm) {
            vm.injectNewFile = 'Salut';
        },
        upload: function (file, parentNodeId , onSuccess) {

            var reader = new FileReader();
            reader.readAsDataURL(file.files[0]);

            reader.onload = function(e) {
                 $http.post(
                   APP,
                   {file : reader.result, filename: file.files[0].name, pNodeId: parentNodeId, action: "UPLOAD", controller: controller, csrf: this.csrfToken}
               ).then( function (promise){
                   if(promise.data.success) {
                       onSuccess(promise) ;
                   }
               });
            };
        },
        deleteNode : function (nodeId) {
            return $http.post(
                APP,
                {nodeId: nodeId, action: "DELETENODE", controller : controller, csrf: this.csrfToken}
            );
        },
        createFolder : function (nodeId, name) {
            return $http.post(
                APP,
                {nodeId: nodeId, name: name, action: "CREATEFOLDER", controller : controller, csrf: this.csrfToken}
            );
        }
    };
});
