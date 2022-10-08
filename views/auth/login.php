<?php $this->layout("layouts/default", ["title" => 'Đăng nhập']) ?>

<?php $this->start("page") ?>

<div class="container-login mt-5" style="margin: 50px auto">
  <div class="row">
    <form id="loginForm" action="/login" method="POST" style="padding: 0">
        <h1 class="header"><i class="fa fa-lock" aria-hidden="true"></i> Login</h1>
          <div class="form-log-content" style="padding: 30px">
            <?php if(isset($messages['error'])): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->e($messages['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>  
            <?php endif; ?>
            <div class="input-group">
              <label for="username"></label>
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
              </div>
              <input id="username" type="text" name="username" class="form-control" placeholder="Tên đăng nhập" 
              value="<?=isset($messages['username']) ? $this->e($messages['username']) : '' ?>" required autofocus/>
            </div><br/>
            <div class="input-group">
              <label for="password"></label>
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-key icon"></i></span>
              </div>
              <input id="password" type="Password" name="password" class="form-control" placeholder="Mật khẩu"/>
              <div></div>
            </div><br>
            <div class="input-group d-flex justify-content-center">
              <input class="form-check-input m-1 fs-7" type="checkbox" id="agree" name="agree" value="agree" />
              <label class="form-check-label" for="agree"> Lưu thông tin đăng nhập ?</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-login p-0"><span class="glyphicon glyphicon-off">Đăng nhập</span></button>
          
          <button type="submit" class="btn btn-info text-light"><span class="glyphicon glyphicon-remove"></span>Login with Facebook </button><br />
          <br/> <center><div style="border:1px solid black;height:1px;width:300px;"></div></center><br />
          <div class="footer-login">
            <p>Bạn không có tài khoản! <a href="/register">Đăng ký tại đây</a></p>
            <p>Quên tài khoản <a href="#">Lấy lại mật khẩu?</a></p>
          </div>
      </form>   
  </div>
</div>
<?php $this->stop() ?>
