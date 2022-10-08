<?php 
    $this->layout("layouts/default", ["title" => 'Trang chủ']);
?>

<?php $this->start("page")?>

<?php
function adddotstring($strNum) {
 
    $len = strlen($strNum);
    $counter = 3;
    $result = "";
    while ($len - $counter >= 0)
    {
        $con = substr($strNum, $len - $counter , 3);
        $result = '.'.$con.$result;
        $counter+= 3;
    }
    $con = substr($strNum, 0 , 3 - ($counter - $len) );
    $result = $con.$result;
    if(substr($result,0,1)=='.'){
        $result=substr($result,1,$len+1);   
    }
    return $result;
}

function renderColorProduct($color){
    switch ($color){
        case 'Xám':
            $name = 'gray'; break;
        case 'Cam':
            $name = 'orange'; break;
        case 'Đen':
            $name = 'black'; break;
        case 'Đỏ':
            $name = 'red'; break;
        case 'Hồng':
            $name = 'pink'; break;
        case 'Trắng':
            $name = 'white'; break;
        case 'Vàng':
            $name = 'yellow'; break;
        case 'Xanh D':
            $name = 'blue'; break;
        case 'Xanh L':
            $name = 'green'; break;
        default: break;
    }
    echo '<input type="button" name="'.$name.'" class="btn '.$name.' m-1"> ';
}

?>


<div  id="product-container" class="container" style="margin-top: 110px">
    <div class="row">
        <div class="col">
            <div id="product-container-navbar" class="d-flex justify-content-around align-items-center">
                
                <div id="menu-product" class="dropdown">
                <button class="btn btn-dark btn-menu-product">
                    <span class="name-type">
                        <?php 
                            echo $categoryType;
                        ?>
                    </span>
                    <div class="btn-icon">
                        <i class="fa-solid fa-caret-down mx-1 icon-down"></i>
                        <i class="fa-solid fa-caret-up mx-1 d-none icon-up"></i>
                    </div>
                </button>
                
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item menu-product__item" href="/product">Tất cả sản phẩm</a></li>
                    <?php
                        foreach($categorys as $category){
                            echo '<li><a class="dropdown-item menu-product__item" href="/product?category='.$category->id.'">'.$category->name.'</a></li>';
                        }
                    ?>
                </ul>
                </div>
                <div id="group-choice" class="btn-group" role="group" aria-label="Basic outlined example">
                <a href="<?php echo isset($_GET['category']) ?  '/product?category='.$_GET['category'].'&act=banchay' :'/product?act=banchay' ?>" type="button" class="btn btn-light btn-item 
                    <?php if(isset($_GET['act']) && $_GET['act'] == 'banchay') echo 'active';?>">Bán chạy nhất
                </a>
                <a href="<?php echo isset($_GET['category']) ? '/product?category='.$_GET['category'].'&act=giamgia' :'/product?act=giamgia' ?>" type="button" class="btn btn-light btn-item 
                    <?php if(isset($_GET['act']) && $_GET['act'] == 'giamgia') echo 'active';?>">Giảm giá
                </a>
                <a href="<?php echo isset($_GET['category']) ? '/product?category='.$_GET['category'].'&act=giacao' :'/product?act=giacao' ?>" type="button" class="btn btn-light btn-item 
                    <?php if(isset($_GET['act']) && $_GET['act'] == 'giacao') echo 'active';?>">Giá cao
                </a>
                <a href="<?php echo isset($_GET['category']) ? '/product?category='.$_GET['category'].'&act=giathap' :'/product?act=giathap' ?>" type="button" class="btn btn-light btn-item 
                    <?php if(isset($_GET['act']) && $_GET['act'] == 'giathap') echo 'active';?>">Giá thấp
                </a>
                </div>
                <div id="group-price" class="dropdown">
                <button class="btn btn-dark btn-menu-product">
                    <span class="name-price">Lọc giá sản phẩm</span>
                    <div class="btn-icon">
                    <i class="fa-solid fa-caret-down mx-1 icon-down"></i>
                    <i class="fa-solid fa-caret-up mx-1 d-none icon-up"></i>
                    </div>
                </button>
                
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php 
                        $request = $_SERVER['REQUEST_URI'];
                        if(isset($_GET['fil'])){
                            $index = strpos($request, '&fil');
                            $request = substr($_SERVER['REQUEST_URI'], 0, $index); 
                        }
                    
                    ?>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=1' ?>">Dưới 100.000 đ</a></li>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=2' ?>">100 - 200.000 đ</a></li>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=3' ?>">200 - 300.000 đ</a></li>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=4' ?>">300 - 400.000 đ</a></li>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=5' ?>">400 - 500.000 đ</a></li>
                    <li><a class="dropdown-item group-price__item" href="<?= $request . '&fil=6' ?>">Hơn 500.000 đ</a></li>
                </ul>
                </div>
            </div>
            
            <div id="product-container-content" class="container">
                <div class="row product-list gy-4"  >
                <?php foreach($products as $index => $product):?>
                    <div class="product__item col-6 col-sm-6 col-md-4 col-lg-3 col-xg-3">
                        <div class="card product__item-card">
                        <div class="image-container">
                            <div class="first">
                                <div class="d-flex justify-content-between align-items-center"> 
                                <span class="discount">-25%</span> 
                                <span class="wishlist"><i href="#" class="fa-solid fa-heart icon-heart"></i></span> 
                                </div>
                            </div> 
                            <div class="thumbnail-image">
                            <img src="<?= $product->image ?>" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="product-detail-container p-3">
                            <h5 class="product-name an-product-name d-inline-block text-center"><?= $product->name ?></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="rating">
                                    <span class="number-start">5</span>
                                    <input type="radio" class="rating-start" name="rating" value="5" id="5">
                                    <label for="5">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="4" id="4">
                                    <label for="4">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="3" id="3">
                                    <label for="3">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="2" id="2">
                                    <label for="2">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="1" id="1">
                                    <label for="1">☆</label>
                                </div>
                                <?= $product->id ?>
                                <a href="/detail?id=<?= $products[$index]->id ?>" class="btn-card"><i class="fa-solid fa-bag-shopping icon"></i></a href="../../views/product_detail/index.php?act=info&id='.$id_product.'">
                                <div class="d-flex flex-column mb-2"> 
                                    <span class="new-price"><?= adddotstring($product->price) ?>đ</span> 
                                    <!-- <small class="old-price text-right"><del>200.000đ</del></small>  -->
                                    
                                </div>
                            </div>

                            
                            <div class="d-flex justify-content-between pt-1">
                                <div class="color-select d-flex"> 
                                <?php foreach($product['colors'] as $colors) :?>
                                    <?= renderColorProduct($colors) ?>  
                                <?php endforeach ?>
                                </div>
                                <div class="d-flex product-size "> 
                                <?php foreach($product['sizes'] as $sizes) :?>
                                    <span class="item-size m-1 btn" type="button"><?= $sizes ?></span> 
                                <?php endforeach ?>
                                     
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                
                </div>
                <?php
                // render paginationno';
                
                if($products){
                    // render previous page
                    $previousPage = $_SERVER['REQUEST_URI'];
                    $maxPage = ceil($numberProduct/$numberItem) - 1;
                    if(!isset($_GET['page'])){
                        $previousPage = $previousPage . '&page=' . $maxPage ;
                    }
                    else{
                        $index = strpos($_SERVER['REQUEST_URI'], '&page');
                        $numberPrevious = $_GET['page'] - 1;
                        if($numberPrevious >= 0)
                            $previousPage = substr($_SERVER['REQUEST_URI'], 0 , $index) . '&page=' . $numberPrevious;
                        else
                            $previousPage = substr($_SERVER['REQUEST_URI'], 0 , $index) . '&page=' . $maxPage;
                    }
                    echo '
                    <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class=" page-item pagination-previous mx-3">
                            <a class="page-link" href="'.$previousPage.'" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                            </li>
                    ';
                    // render number page
                    $currentPage = 0;
                    for($i = 0; $i <= $maxPage; $i++){
                        $a = strpos($_SERVER['REQUEST_URI'], '&page');
                        $a == '' ? $link = $_SERVER['REQUEST_URI']: $link = substr($_SERVER['REQUEST_URI'], 0, $a); 
                        $link .= '&page=' . $i;
                        if(isset($_GET['page'])){
                            $currentPage = $_GET['page'];
                        }
                        if((!$currentPage && $i == 0) || $currentPage == $i)
                            echo '<li class="page-item pagination-item active"><a class="page-link" href="'.$link.'">'.($i + 1).'</a></li>';
                        else    
                            echo '<li class="page-item pagination-item"><a class="page-link" href="'.$link.'">'.($i + 1).'</a></li>';
                        
                    }
                    // // render next page
                    $nextPage = $_SERVER['REQUEST_URI'];
                    if(!isset($_GET['page']))
                        $nextPage = $_SERVER['REQUEST_URI'] . '&page='. 1;
                    else{
                        $index = strpos($_SERVER['REQUEST_URI'], '&page');
                        $numberNext = $_GET['page'] + 1;
                        if($numberNext <= $maxPage)
                            $nextPage = substr($_SERVER['REQUEST_URI'], 0 , $index) . '&page=' . $numberNext;
                        else
                            $nextPage = substr($_SERVER['REQUEST_URI'], 0 , $index) . '&page=' . 0;
                    }
                    echo '
                                <li class="page-item pagination-next mx-3">
                            <a class="page-link" href="'.$nextPage.'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                    ';
                }else{
                    echo '
                    <div class="">
                        <h3 class="text-center">Không có sản phẩm</h3>
                        <img src="https://www.dokantec.com/resources/assets/front/images/no-product-found.png" class="img-fluid rounded">
                    </div>
                    ';
                }
                ?>        
            </div>
            
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    const products = <?php echo json_encode($products); ?>;
    // console.log(products);
      // handle menu product
      $('.menu-product__item').click(function(e){
        $('.name-type').html(e.target.innerHTML);
      })

      // handle menu product
      $('.group-price__item').click(function(e){
        $('.name-price').html(e.target.innerHTML);
      })

      // handle group choice
      $('.btn-item').each(function(index, item){
        item.onclick = function(e){
          $('.btn-item.active').removeClass('active');
          e.target.classList.add('active');
        }
      })

      // handle product item heart
      $('.icon-heart').click(function(e){
          e.target.classList.contains('active') ? e.target.classList.remove('active') : e.target.classList.add('active');
      })

      // handle pagination
      $('.pagination-item').each(function(index, item){
        item.onclick = function(e){
          $('.pagination-item.active').removeClass('active');
          console.log($('.pagination-item.active'))
          e.target.parentElement.classList.add('active');
        }
      })
      
      // handle next page 
      $('.pagination-item').change(function(e){
          console.log(e.target);
      })
    });


  </script>
<?php $this->stop() ?>