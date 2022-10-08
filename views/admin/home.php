<?php 
    $this->layout("admin/default", ["title" => 'Quản trị']);
?>

<?php $this->start("page")?>
<div id="container" class="container" style="margin: 150px auto 100px">
    <div class="row">
      <div class="col-2 box-menu">
        <h3 class="box-menu__header">Quản lý</h3>
        <ul class="list-group">
          <a class="list-group-item" href="/admin/account">Tài khoản</a>
          <a class="list-group-item active" href="/admin/user">Người dùng</a>
          <a class="list-group-item" href="/admin/product">Sản phẩm</a>
          <a class="list-group-item" href="/admin/category">Danh mục</a>
          <a class="list-group-item" href="/admin/order">Đơn hàng</a>
          <a class="list-group-item" href="/admin/statis">Thống kê</a>
        </ul>
      </div>
      <div class="col-10">
          <h1>Trang chu admin</h1>
      </div>
    </div>
</div>

<?php $this->stop() ?>