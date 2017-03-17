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
                    $scope.userObj = [
                        {DATE: '12/10/2015', DOCTOR: 'Mathebula', TYPE: 'GP', PRICE: '1520'},
                        {DATE: '12/10/2015', DOCTOR: 'Mathebula', TYPE: 'GP', PRICE: '1520'},
                        {DATE: '12/10/2015', DOCTOR: 'Mathebula', TYPE: 'GP', PRICE: '1520'},
                        {DATE: '12/10/2015', DOCTOR: 'Mathebula', TYPE: 'GP', PRICE: '1520'},
                        {DATE: '12/10/2015', DOCTOR: 'Mathebula', TYPE: 'GP', PRICE: '1520'}
                    ]

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

                        self.setTab = function(id){

                            self.activeTab = id;

                        }

                    
                    

                }

            }

        })