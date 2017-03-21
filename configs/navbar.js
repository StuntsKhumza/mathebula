   var width_limit = 566;
   
   var addEvent = function (object, type, callback) {

            if (object == null || typeof (object) == 'undefined') return;

            if (object.addEventListener) {
                object.addEventListener(type, callback, false);
            } else if (object.attachEvent) {
                object.attachEvent('on' + type, callback);
            } else {
                object['on' + type] = callback;
            }


        };

        addEvent(window, 'resize', test)

        function test() {
            console.log(window.innerWidth);

            if (window.innerWidth < width_limit) {

                if (getState() == 'block') {
                    document.getElementById("myTopnav").style.display = "none";
                }


            } else if (window.innerWidth > width_limit + 1) {
                if (getState() == 'none') {
                    document.getElementById("myTopnav").style.display = "block";
                }
            }
        }

        function getState() {

            var state = document.getElementById("myTopnav");

            state = window.getComputedStyle(state).getPropertyValue('display');

            return state;

        }

        function showNav() {
            var state = document.getElementById("myTopnav");

            state = window.getComputedStyle(state).getPropertyValue('display');

            switch (state) {
                case "none":
                    document.getElementById("myTopnav").style.display = "block";
                    break;
                case "block":
                    document.getElementById("myTopnav").style.display = "none";
                    break;
            }

        }