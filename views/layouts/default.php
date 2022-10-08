<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title)?></title>
    
    <link rel="stylesheet" href="library\fontawesome-free-5.15.3-web\css\all.min.css">
    <link rel="stylesheet" href="library\fontawesome-free-6.1.0-web\css\all.min.css">

    <link rel="stylesheet" href="library\bootstrap\bootstrap-5.1.3-dist\css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="library\slick\slick-1.8.1\slick\slick.css"\>
    <link rel="stylesheet" href="css\base.css">
    <link rel="stylesheet" href="css\style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    
    <!--  JQuery  -->
    <script type="text/javascript" src="js\jQuery.js"></script>
    <script type="text/javascript" src="js\jquery.validater.js"></script>
    <script type="text/javascript" src="js\validator.js"></script>

    <!-- slick slide -->
    <script type="text/javascript" src="library\slick\slick-1.8.1\\slick\slick.min.js"></script>
    <script type="text/javascript" src="js\slickslider.js"></script>
    
    <!-- bootstrap -->
    <script type="text/javascript" src="library\bootstrap\bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/wow.min.js"></script>

    <?php
      if(isset($_SESSION['messages'])){
        foreach($_SESSION['messages'] as $message){
          echo "<script>alert('$message')</script>";
        }
        $_SESSION['messages'] = null;
      }
    ?>
    

</head>
<body>
    <div id="header" class="container-fruid">
        <nav class="navbar navbar-expand-lg navbar-dark header-navbar">
            <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/home">
                <img src="../../img/logo_meomeo.png" alt="" width="120px">
                <h4 class="m-0">MEOMEO</h4>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form id="search-form" class="d-flex navbar-search" action="/search?" method="get">
                <input class="form-control me-2 navbar-search-input" name="search" type="search" placeholder="Tìm sản phẩm" aria-label="Search">
                <button class="btn btn-outline-success navbar-search-btn" type="submit"><i class="icon-search fas fa-search"></i></button>
                </form>
            </div>
            <div class="navbar-list">
                <div class="navbar-item navbar-item--user">
                <i class="fas fa-user"><span class="navbar-item-name">user</span></i>

                <?php
                    if (isset($_SESSION["user_name"]))
                    {
                        $user = $_SESSION["user_name"];
                        echo "
                            <div class='user-box'>
                            <div class='user-box__header'>
                                <span>$user</span> <span>|</span> <a href='/logout'>Đăng xuất</a>
                                <i class='fas fa-times user-box__header-close'></i>
                            </div>
                            <div class='user-box__content'>
                                <a href='/profile' class='user-box__content-item'>
                                    <i class='fas fa-user-circle'></i>
                                    <span>Tài khoản </span>
                                </a>
                            
                                <a href='/showOrder' class='user-box__content-item'>
                                    <i class='fas fa-box'></i>
                                    <span>Đơn hàng </span>
                                </a>
                            </div>
                            </div>
                        ";
                    }else
                    {
                        echo "
                        <div class='user-box'>
                            <div class='user-box__header'>
                            <a href='/login'>Đăng nhập</a> <span>|</span> <a href='/register'>Đăng ký</a>
                            <i class='fas fa-times user-box__header-close'></i>
                            </div>
                            <div class='user-box__content'>
                            <div class='user-box__content-item'>
                                <i class='fas fa-user-circle'></i>
                                <span>Tài khoản </span>
                            </div>
                            <div class='user-box__content-item'>
                                <i class='fas fa-box'></i>
                                <span>Đơn hàng </span>
                            </div>
                            </div>
                        </div>
                        ";
                
                    }
                    ?>
                    
                </div>
                <div class="navbar-item navbar-item--notify">
                <i class="fas fa-bell"><span class="navbar-item-name">notify</span></i>
                <div class="box-notify" style="width: 400px">
                    <div class="box-notify__header text-center p-2 bg-info rounded-top rounded-2">
                    <span class="text-light">Thông báo mới nhận</span>
                    </div>
                    <div id="box-notify__container" class="box-notify__container p-2" style="max-height: 300px; overflow: auto;">
                  
                    </div>
                    <div class="box-notify__footer text-center p-2">
                    <a href="#" class="text-dark text-decoration-none">Xem tất cả</a>
                    </div>
                </div>
                <div class="navbar-item__box navbar-item__box-notify d-none">
                    <span class="navbar-item__quantity navbar-item__quantity-notify"></span>
                </div>
                </div>
                <div class="navbar-item navbar-item--bag">
                <i class="fas fa-shopping-bag"><span class="navbar-item-name">cart</span></i>
                <div class='bag-box'>
                    <div id="bag-box__list" class="bag-box__container">
                    <img src="./img/empty-cart.jpg" alt="" width="320px">
                    </div>
                    <div class="bag-box__footer">
                        <a href="/showCart" class="btn btn-danger">Xem vỏ hàng</a>
                    </div>
                </div>
                <div class="navbar-item__box navbar-item__box-bag d-none">
                    <span class="navbar-item__quantity navbar-item__quantity-bag"></span>
                </div>
                </div>
            </div>
            </div>
        </nav>
        <ul class="nav nav-tabs navbar-dark header-nav-sub">
        <div class="container navbar-sub">
            <li class="nav-item">
            <a class="nav-link" href="/product">Sản phẩm</a>
            </li>
            <?php
            if(isset($_SESSION['rule']) && $_SESSION['rule'] == 'admin'){
                echo '<li class="nav-item">
                        <a class="nav-link" href="/admin">Quản trị</a>
                    </li>';
            }

            ?>
        </div>
        </ul>
  </div>

  
    <div id="container" >
        <?=$this->section("page")?>
    </div>

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



    <script type="text/javascript">
      const id = <?= $_SESSION['user_id'] ?? 0 ?>;    
      showCart(id);
      function showCart(id) {
          if (id == "") {
              document.getElementById("bag-box__list").innerHTML = '<img src="./img/empty-cart.jpg" alt="" width="320px">';
              return;
          }
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              document.getElementById("bag-box__list").innerHTML = this.responseText;
              const number = this.responseText.split('bag-item d-flex justify-content-between align-items-center mb-2').length - 1;
              if(number > 0){
                const element = document.querySelector('.navbar-item__quantity-bag');
                element.innerHTML = number;
                document.querySelector('.navbar-item__box-bag').classList.remove('d-none');
              }else{
                document.querySelector('.navbar-item__box-bag').classList.add('d-none');
              }
            }
          xhttp.open("GET", "/getCart&id="+id);
          xhttp.send();
      }

      function deleteItem(id_user, id_product, color, size, quantity){
        $.ajax({
          url: "/cart/deleteItem&id="+id,
          method: "POST",
          data: { id_user: id_user, id_product: id_product, color: color, size: size, quantity: quantity},
          cache: false,
          error: function(xhr ,text){
              alert('Đã có lỗi: ' + text);
          }
        });
        showCart(id_user);
        // showItem(id_user);
      }

      showNotify();
      function showNotify(){
          // if (id == "") {
          //   document.getElementById("bag-box__list").innerHTML = '<img src="./img/empty-cart.jpg" alt="" width="320px">';
          //   return;
          // }
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              document.getElementById("box-notify__container").innerHTML = this.responseText;
              const number = this.responseText.split('bag-item d-flex justify-content-between align-items-center mb-2').length - 1;
              if(number > 0){
                const element = document.querySelector('.navbar-item__quantity-bag');
                element.innerHTML = number;
                // document.querySelector('.navbar-item__box-bag').classList.remove('d-none');
              }else{
                // document.querySelector('.navbar-item__box-bag').classList.add('d-none');
              }
            }
          xhttp.open("GET", "/showNotify&id="+id);
          xhttp.send();
      }

      handleQuantityNotify();
      function handleQuantityNotify(){
        const elementNotify = document.querySelectorAll('.box-notify__item.bg-secondary');
        const boxQuantity = document.querySelector('.navbar-item__box-notify');
        const notifyQuantity = document.querySelector('.navbar-item__quantity-notify');
        if(elementNotify.length > 0){
          boxQuantity.classList.remove('d-none');
          notifyQuantity.innerHTML = elementNotify.length;
        }else{
          boxQuantity.classList.add('d-none');
          notifyQuantity.innerHTML = 0;
        }
      }

      
      function watch(element){
        if(element.classList.contains("bg-secondary")){
          element.classList.remove('bg-secondary');
          handleQuantityNotify();
          const elementId = element.querySelector('.notify-id');
          const id = parseInt(elementId.value);
          $.ajax({
            url: "/watchedNotify",
            method: "POST",
            data:  { id_notify: id},
            cache: false,
            error: function(xhr ,text){
                alert('Đã có lỗi: ' + text);
            }
          });
        }
      } 

      
    
  </script>

    <?=$this->section("page_specific_js")?>
</body>
</html>
