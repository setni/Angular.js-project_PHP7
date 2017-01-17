angular.module('routeApp').factory('Upload', function($http, $location, $sce) {
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
