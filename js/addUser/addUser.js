angular.module('addUserProfile-app', ['ui.router', 'profilePictureApp', 'nav-app', 'session-app'])

    /*       .directive('addUserProfile', function () {
   
               return {
                   restrict: "E",
                   templateUrl: "js/addUser/addUser.html", 
                   controller:function ($scope) {
   
                   }
   
               }
   
           }) */
    .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('adduserprofile', {
                controllerAs: 'adduserprofileController',
                templateUrl: "js/addUser/addUser.html",
                url: '/adduserprofile',
                controller: function ($scope, $state, $http, $anchorScroll, getActiveSession, serviceSession, $location) {

                    if (getActiveSession.status == "false") {
                        $state.go("login");
                        return;
                    }

                    var self = this;
                    self.message = "";
                    self.showErrorMessage = false;
                    self.showSuccessMessage = false;
                    self.patientobj = {
                        data : {
                            PATIENTNAME:"",
                            PATIENTSURNAME:"",
                            PATIENTTITLE:"",
                            PATIENTDOB:"",
                            PATIENTIDNUMBER:"",
                            PATIENTMARITALSTATUS:"",
                            PATIENTHOMEADDRESS1:"",
                            PATIENTHOMEADDRESS2:"",
                            PATIENTHOMEADDRESS3:"",
                            PATIENTHOMEADDRESSCODE:"",
                            PATIENTTELL:"",
                            PATIENTCELL:"",
                            PATIENTPOSTALADDRESS1:"",
                            PATIENTPOSTALADDRESS2:"",
                            PATIENTPOSTALADDRESS3:"",
                            PATIENTPOSTALADDRESSCODE:"",
                            PATIENTSPOUSETELL:"",
                            PATIENTSPOUSECELL:"",
                            PATIENTEMPLOYER:"",
                            PATIENTOCCUPATION:"",
                            PATIENTOCCUPATIONADDRESS1:"",
                            PATIENTOCCUPATIONADDRESS2:"",
                            PATIENTOCCUPATIONADDRESS3:"",
                            PATIENTOCCUPATIONTELL:"",
                            PATIENTHOUSEDOCTOR:"",
                            PATIENTMEDICALAID:"",
                            PATIENTMEDICALAIDNAME:"",
                            PATIENTMEDICALAIDPLAN:"",
                            PATIENTMEDICALAIDNUMBER:"",
                            PATIENTMEDICALAIOTHER:"",
                            PATIENTTYPE:"",
                            PATIENTCARDNUMBER:"",
                        }
                    }
                    self.userRoles = serviceSession.get_roles();

                    self.access = {
                        admin: isMember('[admin]', self.userRoles),
                        doctor: isMember('[doctor]', self.userRoles),
                        reception: isMember('[reception]', self.userRoles)

                    }

                    self.navbtns = {
                        active: 'ADDPATIENT',
                        hide: {
                            bookings: true,
                            queu:true,
                        }
                    }
                   // $scope.genNumber ();

                    self.genNumber = function () {
                        if (self.patientobj.data.PATIENTTYPE == ""){

                            return;
                        }
                        var formData = new FormData();

                        formData.append("q", "getCardNumber");
                        formData.append("TYPE", self.patientobj.data.PATIENTTYPE);
                        
                        serviceSession.callService(formData)
                        .then(function(res){
                            self.patientobj.data.PATIENTCARDNUMBER = self.patientobj.data.PATIENTTYPE + res.data;
                        })


                    }

                    self.savePatient = function(){

                       

                        var data = self.patientobj.data;

                        var formData = new FormData();
                        formData.append("q", "createPatient");
                        for(var i in data){
                            
                            formData.append(i, data[i]);
                        }

                        /* self.message = "Please specify patient type";
                        self.showErrorMessage = true;
                        
                        $location.hash("alertMessage");
                        $anchorScroll(); */

                        serviceSession.callService(formData).
                        then(function(res){

                            if(res.status == 200){

                                showAlert("good", res.message);

                            }else{
                                showAlert("bad", res.message);
                            }

                        })
                        

                    }

                    function showAlert(type, message){

                        self.showErrorMessage = false;
                        self.showSuccessMessage = false;

                        if(type =="bad"){
                              self.message = message;
                        self.showErrorMessage = true;
                        }else{
                            self.message = message;
                            self.showSuccessMessage = true;
                        }

                        $location.hash("alertMessage");
                        $anchorScroll(); 

                    }



                },
                resolve: {
                    getActiveSession: function ($http) {
                        return $http.get('php/service.php?q=getSession')
                            .then(function (response) {
                                return response.data;
                            })
                    }
                }
            })
    })