<?php 
    $this->layout("layouts/default", ["title" => 'Trang chủ']);
?>

<?php $this->start("page")?>
<form action="/upload" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="file" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
<?php $this->stop() ?>