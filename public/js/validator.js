
$.validator.setDefaults({
    submitHandler: function () { return test(); }
    
});

$(document).ready(function () {
    $("#registerForm").validate({
        rules: {
            fullname: "required",
            username: "required",
            username: { required: true, minlength: 2 },
            password: { required: true, minlength: 5},
            confirm: { required: true, minlength: 5, equalTo: "#password"},
            email: { required: true, email: true }
        },
        messages: {
            fullname: "Bạn chưa nhập vào họ của bạn",
            username: {
                required: "Bạn chưa nhập vào tên đăng nhập",
                minlength: "Tên đăng nhập phải có ít nhất 2 ký tự"
            },
            password: {
                required: "Bạn chưa nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 5 ký tự"
            },
            confirm_password: {
                required: "Bạn chưa nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 5 ký tự",
                equalTo: "Mật khẩu không trùng khớp với mật khẩu đã nhập"
            },
            email: "Hộp thư điện tử không hợp lệ"
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox"){
                error.insertAfter(element.siblings("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass){
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
    $("#loginForm").validate({
        rules: {
            username: "required",
            username: { required: true, minlength: 2 },
            password: { required: true, minlength: 5 }
        },
        messages: {
            username: {
                required: "Bạn chưa nhập vào tên đăng nhập",
                minlength: "Tên đăng nhập phải có ít nhất 2 ký tự"
            },
            password: {
                required: "Bạn chưa nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 5 ký tự"
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox"){
                error.insertAfter(element.siblings("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass){
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
    
});