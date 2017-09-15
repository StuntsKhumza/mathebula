angular.module('userProfile-app', ['comments-app', 
'profilePictureApp',
'userProfile-General-app',
'userProfile-Address-app',
'userProfile-pastMedicalHistory-app',
'save-app',
'session-app'
])

        .directive('userProfile', function () {

            return {
                restrict: "E",
                templateUrl: "js/userProfile/userProfile.html",
                controllerAs: 'userProfileController',
                controller: function ($scope,serviceSession) {

                    var self = this;
                    self.activeTab = 1;
                    self.setUser = $scope.userObj.client;
                    self.setUser;
                    self.dependents = [];
                    $scope.tab_count = 1;
                   //  console.log(self.setUser);
                   loadDependents();
                    function loadDependents() {
                        
                        var formData = new FormData();

                        formData.append("q","getDependents");
                        formData.append("MAINID",self.setUser.PATIENTID);

                        serviceSession.callService(formData)
                        .then(function(res){
                            self.dependents = res;
                            console.log(self.dependents.data);
                            console.log(self.dependents);
                            
                        })
                    }

                    $scope.userDataObj = 
                        {
                            //general
                            general: {
                                txt_name: self.setUser.FIRSTNAME,
                                txt_surname: self.setUser.LASTNAME,
                                txt_dateofbirth: "1990/03/23",
                            },
                            
                            address: {
                                txt_line1:self.setUser.ADDRESS1,
                                txt_line2:self.setUser.ADDRESS2,
                                txt_line3:self.setUser.ADDRESS3
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