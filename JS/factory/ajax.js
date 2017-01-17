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
});
