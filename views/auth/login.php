<?php $this->layout("layouts/default", ["title" => 'MeoMeo123']) ?>

<?php $this->start("page") ?>
<div class="containe py-5" >
  <section class="bg-image">
    <div class="mask d-flex align-items-center gradient-custom-3">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-12 col-md-12 col-lg-5 col-xl-5">
            <div class="card" style="border-radius: 6px;">
              <div class="card-body p-4">
                <h4 class="text-uppercase text-center mb-4">ĐĂNG NHẬP</h4>

                <form id="form-login" class="form-horizontal" role="form" method="POST" action="/login">
                  <div class="form-outline mb-3 <?=isset($errors['email']) ? ' has-error' : '' ?>">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" id="email" name="email" class="form-control form-control-md" placeholder="Nhập tài khoản email" 
                      value="<?=isset($old['email']) ? $this->e($old['email']) : '' ?>" required/>
                      <?php if (isset($errors['email'])): ?>
                          <span class="help-block">
                              <span class="text-danger"><?=$this->e($errors['email'])?></span>
                          </span>
                      <?php endif ?>
                  </div>
                  <div class="form-outline mb-3 <?=isset($errors['password']) ? ' has-error' : '' ?>">
                      <label class="form-label" for="password">Mật khẩu</label>
                      <input type="password" id="password" name="password" class="form-control form-control-md" placeholder="Nhập mật khẩu" required/>
                      <?php if (isset($errors['password'])): ?>
                          <span class="help-block">
                              <span class="text-danger"><?=$this->e($errors['password'])?></span>
                          </span>
                      <?php endif ?>
                  </div>

                  <div class="form-check d-flex justify-content-center mb-4">
                      <label class="form-check-label">
                        <input
                          class="form-check-input me-2"
                          type="checkbox"
                          value=""
                          id="form2Example3cg"
                        />
                      Lưu thông tin đăng nhập!
                    </label>
                  </div>

                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-block btn-lg btn-reg text-light">Đăng nhập</button>
                  </div>

                  <p class="text-center text-muted mt-4 mb-0">Bạn chưa có tài khoản? <a href="/register" class="fw-bold text-primary text-decoration-none"><u>Đăng ký</u></a></p>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>

$.validator.setDefaults({
    submitHandler: function () { return test(); }
    
});
$("#form-login").validate({
      rules: {
        email: { required: true, email: true },
        password: { required: true, minlength: 5 }
      },
      messages: {
        password: {
          required: "Bạn chưa nhập mật khẩu",
          minlength: "Mật khẩu phải có ít nhất 5 ký tự"
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
</script>
<?php $this->stop() ?>
