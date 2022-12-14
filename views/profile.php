<?php 
    $this->layout("layouts/default", ["title" => 'Thông tin người dùng']);
?>

<?php $this->start("page")?>

<div id="container">
    <div class="container pt-md-5">
        <div class="row">
        <div class="col-lg-4">
            <div class="card" style="border: unset; background-color: unset;">
                <div id="profile" class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="profile-avatar">
                        <img src="<?= $user->avatar ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                        <span class="btn-upload-avatar fa-solid fa-camera-rotate" data-bs-toggle="modal" data-bs-target="#exampleModal"></span>
                      </div>
                    
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <form id="form-upload" action="/profile/update/avatar?id=<?= $user->id ?>" enctype="multipart/form-data" method="post">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                  <div class="modal-header d-flex justify-content-center bg-primary text-light">
                                    <h3 class="text-center">Tải Ảnh Đại Diện</h3>
                                  </div>
                                  <div class="modal-body">
                                    <img id="avatar-upload" class="rounded-circle p-1 bg-primary" width="200" height="200" src="<?= $user->avatar ?>" alt="">
                                    <input id="file-upload" name="file" type="file">
                                  </div>
                                  <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                  </div>
                              </div>
                            </div>
                          </form>
                        </div>
                    <div class="mt-3">
                    <h4 id="profile-fullname"><?php echo $user->fullname ?></h4>
                    <p id="profile-birthdate" class="text-secondary"><?php echo substr($user->birthdate, 8, 2). '-' . substr($user->birthdate, 5, 2). '-' .substr($user->birthdate, 0, 4) ?></p>
                    <p id="profile-address" class=""><?php echo $user->address ?></p>
                    <p id="profile-telephone" class=""><?php echo $user->telephone ?></p>
                    <!-- <button class="btn btn-primary">Follow</button>
                    <button class="btn btn-outline-primary">Message</button> -->
                    </div>
                </div>
                <hr class="my-4">
                <div class="d-flex flex-column align-items-center text-center">

                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-8 mb-5">
            <div class="card">
                <div class="card-body body-form">
                <nav class="navbar profile-navbar">
                    <div class="nav-item nav-item--left active">
                        <span>Hồ sơ</span>
                    </div>
                    <div class="nav-item nav-item--right">
                        <span>Đổi mật khẩu</span>
                    </div>
                </nav>
                <form id="form-user" action="/profile/update/info?id=<?=$user->id?>" enctype="multipart/form-data" method="post">
                    <table class="table-user">
                        <tbody>
                            <tr class="row mb-3 d-flex">
                                <td class="col-4 text-end"><b>Họ và tên:</b></td>
                                <td class="col-8"><input class="px-2 py-1" type="text" name="fullname" id="form-user__fullname" value="<?=$user->fullname?>"></td>
                            </tr>
                            <tr class="row mb-3">
                                <td class="col-4 text-end"><b>Email: </b></td>
                                <td  class="col-8"><input class="px-2 py-1" type="text" name="email" class="form-user__email" value="<?=$user->email?>"></td>
                            </tr>
                            <tr class="row mb-3">
                                <td class="col-4 text-end">
                                    <label for="gender"><b>Giới tính: </b></label>
                                </td>
                                <td class="col-8 ">
                                    <?php
                                        if($user->gender == 'Nam')
                                            echo '<input type="radio" id="Nam" class="gender" name="gender" value="Nam" checked>
                                            <label for="Nam" class="gender-lable">Nam </label>';
                                        else  
                                            echo '<input type="radio" id="Nam" class="gender" name="gender" value="Nam">
                                            <label for="Nam" class="gender-lable">Nam </label>';
                                        if($user->gender == 'Nữ')
                                            echo '<input type="radio" id="Nữ" class="gender" name="gender" value="Nữ" checked>
                                            <label for="Nữ" class="gender-lable">Nữ</label>';
                                        else
                                            echo '<input type="radio" id="Nữ" class="gender" name="gender" value="Nữ">
                                            <label for="Nữ" class="gender-lable">Nữ</label>';
                                        if($user->gender == 'Khác')
                                            echo '<input type="radio" id="Khác" class="gender" name="gender" value="Khác" checked>
                                            <label for="Khác" class="gender-lable">Khác</label>';
                                        else    
                                            echo '<input type="radio" id="Khác" class="gender" name="gender" value="Khác">
                                            <label for="Khác" class="gender-lable">Khác</label>';
                                    ?>
                                </td>
                            </tr>
                            <tr class="row mb-3">
                                <td class="col-4 text-end"><b>Ngày sinh: </b></td>
                                <td class="col-8"><input class="px-2 py-1 user-birthdate" id="birthdate" name="birthdate" type="date" value="<?=$user->birthdate?>"></td>
                            </tr>
                            <tr class="row mb-3">
                                <td class="col-4 text-end"><b>Địa chỉ: </b></td>
                                <td class="col-8"><input class="px-2 py-1" id="address" name="address" type="text" value="<?=$user->address?>"></td>
                            </tr>
                            <tr class="row mb-3">
                                <td class="col-4 text-end"><b>SĐT: </b></td>
                                <td  class="col-8"><input class="px-2 py-1" id="telephone" name="telephone" type="tel" value="<?=$user->telephone?>"></td>
                            </tr>
                            <tr class="row mt-2">
                                <td class="col-12 text-center"><button type="submit" class="btn-1 btn btn-submit btn-primary">Lưu chỉnh sửa</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <form id="form-account" class="d-none" action="/profile/update/password?id=<?= $user->id ?>" enctype="multipart/form-data" method="post">
                    <table class="table-user">
                        <tbody>
                            <tr class="row mb-3 d-flex">
                                <td class="col-4 text-end"><b>Mật khẩu cũ:</b></td>
                                <td class="col-8"><input class="px-2 py-1" type="password" name="password_old" id="form-account__password" placeholder="password old"></td>
                            </tr>
                            <tr class="row mb-3 d-flex">
                                <td class="col-4 text-end"><b>Mật khẩu mới:</b></td>
                                <td class="col-8"><input class="px-2 py-1" type="password" name="password_new" id="form-account__password-new" placeholder="password new"></td>
                            </tr>
                            <tr class="row mb-3 d-flex">
                                <td class="col-4 text-end"><b>Nhập lại MK:</b></td>
                                <td class="col-8"><input class="px-2 py-1" type="password" name="confirm" id="form-account__password-confirm" placeholder="confirm password"></td>
                            </tr>
                            <tr class="row mt-2">
                                <td class="col-12 text-center"><button type="submit" class="btn-1 btn btn-submit btn-primary">Lưu chỉnh sửa</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // const text = ;
    // const gender = text.value;

    $.validator.setDefaults({
        submitHandler: function () { 
          return true; 
        }
    });
    $("#form-account").validate({
          rules: {
              password_old: { required: true, minlength: 5 },
              password_new: { required: true, minlength: 5 },
              confirm: { required: true, minlength: 5, equalTo: "#form-account__password-new"}
          },
          messages: {
              password_old: {
                  required: "Bạn chưa nhập mật khẩu cũ",
                  minlength: "Mật khẩu phải có ít nhất 5 ký tự"
              },
              password_new: {
                  required: "Bạn chưa nhập mật khẩu mới",
                  minlength: "Mật khẩu phải có ít nhất 5 ký tự"
              },
              confirm_password: {
                  required: "Bạn chưa nhập lại mật khẩu",
                  minlength: "Mật khẩu phải có ít nhất 5 ký tự",
                  equalTo: "Mật khẩu không trùng khớp với mật khẩu đã nhập"
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
      $("#form-user").validate({
          rules: {
              fullname: "required",
              email: { required: true, email: true }
          },
          messages: {
            fullname: "Họ và tên không được rỗng",
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

    $(document).ready(function(){
        // $('.gender').each(function(index, item){
        //     if(gender == item.value){
        //         item.checked = true;
        //     }
        // })

        $('#file-upload').change( function(event) {
            var tmppath = URL.createObjectURL(event.target.files[0]);
            $("#avatar-upload").fadeIn("fast").attr('src',tmppath); 
        });

       $('.nav-item--right').click(function(e){
         $('#form-account').removeClass('d-none');
         $('.nav-item--right').addClass('active');
         $('#form-user').addClass('d-none');
         $('.nav-item--left').removeClass('active');

       })
       $('.nav-item--left').click(function(e){
        $('#form-account').addClass('d-none');
         $('.nav-item--right').removeClass('active');
         $('#form-user').removeClass('d-none');
         $('.nav-item--left').addClass('active');
       })
    });


</script>

<?php $this->stop() ?>