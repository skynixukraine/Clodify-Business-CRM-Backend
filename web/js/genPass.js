/**
 * Created by Khomenko on 15.02.2016.
 */
var inviteModule = (function(){

    return {
        init:function(){
            //var pass = '';
            function generateRandomId () {

                var id = '',
                    charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuvwxyz0123456789',
                    charSetSize =61,
                    charCount = 8;

                for ( var i = 1; i <= charCount; i++ ) {

                    var randPos = Math.floor( Math.random() * charSetSize );
                    id += charSet[ randPos ];

                }
                return id;
            }
            $('.generate').click(function(){
                pass = generateRandomId();
                console.log(pass);
                $('#exampleInputPassword1').val(pass);
            })

        }
    }
})();