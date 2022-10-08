<?php 
    $this->layout("admin/default", ["title" => 'Quản trị thống kê']);
?>

<?php $this->start("page")?>
<style>
  .order-nav {
    background-color: #b4daef !important;
  }
  .order-nav a {
    color: #333 !important;
  }
  .order-nav a.active{
    color: red !important;
    background-color: #fff !important;
  }
  .order-nav a:hover {
    cursor: pointer;
    color: red !important;
    background-color: #fff !important;
  }
</style>

<div id="container" class="container" style="margin: 120px auto 100px">
    <div class="row">
      <div class="col-2 box-menu">
        <h3 class="box-menu__header">Quản lý</h3>
        <ul class="list-group">
          <a class="list-group-item" href="/admin/account">Tài khoản</a>
          <a class="list-group-item" href="/admin/user">Người dùng</a>
          <a class="list-group-item" href="/admin/product">Sản phẩm</a>
          <a class="list-group-item" href="/admin/category">Danh mục</a>
          <a class="list-group-item" href="/admin/order">Đơn hàng</a>
          <a class="list-group-item active" href="/admin/statis">Thống kê</a>
        </ul>
      </div>
      <div class="col-10">
        <div class="admin-content__heading bg-secondary d-flex justify-content-md-around">
          <h3 class="display-7">Thống kê</h3>
        </div>
        <div class="bg-light">
          <nav class="d-flex justify-content-start border-bottom order-nav bg-info">
            <a href="/admin/statis?statis=chart" class="text-dark px-4 py-2 text-decoration-none <?php if($static == "chart") echo "active"?>">Biểu đồ</a>
            <a href="/admin/statis?statis=table" class="text-dark px-4 py-2 text-decoration-none <?php if($static == "table") echo "active"?> ">Thống kê</a>
          </nav>
          <?php if($static == 'chart'):?>
          <div class="d-flex justify-content-center">
            <form class="d-flex m-2" style="width: 200px ; height: 30px" action="/admin/statis?statis=chart" method="post">
              <span class="px-3">Năm:</span>
              <input type="text" class="form-control p-2" name="year" id="datepicker" value="<?= isset($year) ? $year : '2022'; ?>"/>
              <button class=" btn-success mx-2">Xem</button>
            </form>
          </div>
          <div class="d-flex justify-content-center">
            <div class="col-6">
              <canvas id="myChart" width="300" height="300"></canvas>
            </div>
          </div>
          <p class="text-center p-3">Biểu đồ thống kê danh số bán hàng</p>
            
            
          <?php endif; ?>
          <?php if($static == 'table'): ?>
            <div class="d-flex justify-content-center">
            <form class="d-flex m-2" style="width: 200px ; height: 30px" action="/admin/statis?statis=table" method="post">
              <span class="px-3">Năm:</span>
              <input type="text" class="form-control p-2" name="year" id="datepicker" value="<?= isset($year) ? $year : '2022'; ?>"/>
              <button class=" btn-success mx-2">Xem</button>
            </form>
          </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Tháng</th>
                  <th scope="col" class="text-center">Số đơn hàng</th>
                  <th scope="col" class="text-center">Tổng danh thu (đ)</th>
                  <th scope="col" class="text-center">Số sản phẩm được bán</th>
                </tr>
              </thead>
              <tbody>
                <?php for($i=1; $i<=12; $i++): ?>
                  <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td><?= $numberOrders[$i-1] ?></td>
                    <td><?= $totals[$i-1] ?></td>
                    <td><?= $numberProducts[$i-1] ?></td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
</div>


<script>
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
   });  
  var totals = <?php echo json_encode($totals) ?>;
  var labels = [1,2,3,4,5,6,7,8,9,10,11,12];
  const data = {
    labels: labels,
    datasets: [{
      label: 'Danh số bán hàng',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: totals,
    }]
  };
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });
</script>
<?php $this->stop() ?>