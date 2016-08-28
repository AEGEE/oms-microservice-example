(function ()
{
    'use strict';
    var baseUrl = baseUrlRepository['module_poc'];


    angular
        .module('app.hello_world', [])
        .config(config)
        .controller('HWController', HWController);

    /** @ngInject */
    function config($stateProvider)
    {
        // State
         $stateProvider
            .state('app.hello_world', {
                url: '/hello_world',
                data: {'pageTitle': 'Hello world'},
                views   : {
                    'pageContent@app': {
                        templateUrl: baseUrl+'frontend/hello_world/hello_world.html',
                        controller: 'HWController as vm'
                    }
                }
            });
    }

    function HWController($http) {
        // Data

        var vm = this;
        vm.user = {};
        
        // Methods
        vm.getUserData = function() {
            $('#loadingOverlay').show();
            $http({
                method: 'GET',
                url: baseUrl+"api/getUserData"
            }).then(function successCallback(response) {
                if(response.data.success == '1') {
                    vm.user = response.data.user;
                } else  {
                    $.gritter.add({
                        title: 'Error!',
                        text: response.data.message,
                        sticky: true,
                        time: '',
                        class_name: 'my-sticky-class'
                    });
                }
                $('#loadingOverlay').hide();
            })
        }

        /////
        vm.getUserData();
    }

})();