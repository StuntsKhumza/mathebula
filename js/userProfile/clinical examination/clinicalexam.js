angular.module('userProfile-ClinicalExam-app', [])

    .directive('clinicalExamTab', function () {

        return {
            restrict: "E",
            templateUrl: "js/userProfile/clinical examination/clinicalexam.html",
            controllerAs: 'clinicalexamCtr',
            controller: function ($scope) {
                var self = this;
                self.examining = "";
                self.setClick = function(c){
                    self.examining = c;
                }

            }

        }

    })