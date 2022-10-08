<?php 
    $this->layout("layouts/default", ["title" => 'Thông tin tài khoản']);
    $user_id = $_SESSION['user_id'];
?>

<?php $this->start("page")?>
<footer id="footer">
  <div class="container footer-contact-form">
    <div class="row">
      <div class="col-4 contact__form-left">
        <i class="fas fa-paper-plane"></i>
        <div class="content">
          <h2>Liên Hệ Ngay</h2>
          <span>Tư Vấn Miễn Phí</span>
        </div>
      </div>
      <div class="col-4 offset-4 contact__form-right">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nhập email của bạn">
          <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
        </div>
      </div>
    </div>
  </div>
  <div class="footer site-footer">
    <div class="container opacity">
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <h6>Liên kết nhanh</h6>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-caret-right"></i>Trang chủ</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Giới thiệu</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Sản phẩm</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Blog</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Liên hệ</a></li>
          </ul>
        </div>

        <div class="col-xs-6 col-md-3">
          <h6>Dịch vụ</h6>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-caret-right"></i>Tìm kiếm</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Giới thiệu</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Chính sách đổi trả</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>Điều khoản dịch vụ</a></li>
          </ul>
        </div>
        <div class="col-xs-6 col-md-3">
          <h6>Địa chỉ</h6>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-caret-right"></i>132 - 3/2, Q. Ninh Kiều, Cần Thơ</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>0909090909</a></li>
            <li><a href="#"><i class="fas fa-caret-right"></i>7h00 - 22h00</a></li>
          </ul>
        </div>

        <div class="col-xs-6 col-md-3">
          <h6>Mua sắm tại</h6>
          <ul class="footer-links">
            <li><i class="fas fa-caret-right"></i><span>Bạn đang ở Cần Thơ | <a href="#">Thay đổi</a></span></li>
          </ul>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12">
          <p class="cop yright-text">Copyright &copy; 2021 All Rights Reserved by 
            <a href="#">MeoMeo</a>.
          </p>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <ul class="social-icons">
            <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
            <li><a class="dribbble" href="#"><i class="fab fa-dribbble"></i></a></li>
            <li><a class="linkedin" href="#"><i class="fab fa-linkedin"></i></a></li>   
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>


<?php $this->stop() ?>