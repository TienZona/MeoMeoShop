<?php 
    $this->layout("layouts/default", ["title" => 'Trang chủ']);
?>

<?php $this->start("page")?>
<div id="container">
    <div class="container">
    <div class="slider-show">
        <div class="slider-show__img"><img src="https://bizweb.dktcdn.net/100/243/902/themes/573935/assets/slider_2.jpg?1621146545042" alt="" ></div>
        <div class="slider-show__img"><img src="../../img/slider-1.jpg" alt=""></div>
        <div class="slider-show__img"><img src="https://canadasbeststorefixtures.com/wp-content/uploads/2018/10/Slider-4.jpg" alt=""></div>
    </div>
    </div>
    <div class="highlight-product">
    <div class="container">
        <div class="highlight__heading">
        <h1>Các sản phẩm mới nhất</h1>
        </div>
        <div class="highlight__slider row">
            <?php
            foreach($products as $product){
                echo '<a href="/detail?id='.$product['id'].'" class="highlight__slider-item"><img src="../../img/'.$product->image.'" alt=""></a>';
            }
            ?> 
        </div>
    </div>
    </div>
    <div class="container-service">
    <div class="container p-md-5 text-center">
        <h2 class="heading">Shop thời trang MeoMeo</h2>
        <span class="fst-italic fs-6 caption">Fashion - Forever</span>
        <p class="p-md-3 fs-5 lh-base">Với uy tín hơn 10 năm hoạt động trong lĩnh vực thời trang, 
        chúng tôi rất mong muốn giúp bạn có những bộ quần áo lộng lẫy.
        Với hệ thống cửa hàng trên toàn quốc, chúng tôi luôn cung cấp 
        đủ loại mẫu mã luôn luôn chạy theo xu hướng thời trang toàn cầu. 
        Vì vậy, chúng tôi luôn mang đến cho quý khách hàng những sản quần
        áo thời trang giá rẻ và đẹp nhất mà quý khách có thể hoàn toàn yên tâm về chất lượng…
        </p>
    </div>
    </div>
    <div class="container-contact">
    <div class="container text-center p-5">
        <h3 class="heading-1">LIÊN HỆ NGAY</h3>
        <h2 class="heading-2">LIÊN HỆ NGAY VỚI CHÚNG TÔI ĐỂ ĐƯỢC ĐỘI NGŨ TƯ VẤN HỔ TRỢ VÀ GIẢI ĐÁP THẮC MẮT CHO BẠN NHÉ!</h2>
        <button class="btn mt-4">Liên hệ</button>
    </div>
    </div>
</div>

<?php $this->stop() ?>