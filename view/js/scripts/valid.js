$(function () {
    $("#login-form").validate({
        rules:{
            nick:{
                required:true
            },
            pass:{
                required:true
            }
        }
    });

    $("#add-form").validate({
        rules:{
            name:{
                required:true
            },
            nick:{
                required:true
            },
            pass:{
                required:true
            }
        }
    });
});

function Validar() {
    $("#add-form").validate({
        rules:{
            name:{
                required:true
            },
            nick:{
                required:true
            },
            pass:{
                required:true
            },
            funcion:{
                required:true
            },
            desc:{
                required:true
            }
        }
    });
}