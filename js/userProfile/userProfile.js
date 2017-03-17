angular.module('userProfile-app', ['comments-app', 
'profilePicture',
'userProfile-General-app',
'userProfile-Address-app',
'userProfile-pastMedicalHistory-app'
])

        .directive('userProfile', function () {

            return {
                restrict: "E",
                templateUrl: "js/userProfile/userProfile.html",
                controllerAs: 'userProfileController',
                controller: function ($scope) {

                    var self = this;
                    self.activeTab = 1;
                    

                    $scope.userDataObj = 
                        {
                            //general
                            general: {
                                txt_name: "Nkosinathi",
                                txt_surname: "Khumalo",
                                txt_dateofbirth: "1990/03/23",
                            },
                            
                            address: {
                                txt_line1:"49/614 Lulonga Crescent Ave",
                                txt_line2:"Zandspruit",
                                txt_line3:"2169"
                            },
                            
                            history: {
                                txt_previusPhycName: "Dr T Shongwe",
                                txt_hospitalizedBefore: "No",
                                txt_testedForHapititsB: "No",
                                txt_beenVaxinated: "Yes"
                            }
                        }

                        self.return_to_search = function(){
                            $scope.userObj.client = null;
                            $scope.userObj.clientSet = false;
                        }

                        self.setTab = function(id){

                            self.activeTab = id;

                        }

                    
                    

                }

            }

        })