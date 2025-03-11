 <!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>


<script>    // js có thể hiện hình ảnh ở trong thêm sản phẩm //

    function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();
    
    reader.onload = function(){
        var imgElement = document.getElementById("imagePreview");
        imgElement.src = reader.result; // Gán ảnh vào thẻ <img>
        imgElement.style.display = "block"; // Hiển thị ảnh
    };
    
    reader.readAsDataURL(input.files[0]); // Đọc file ảnh
}
</script>



<script>// js để có thể hiện ô đường kính khi nhấp chọn đồng hồ treo tường ở themsanpham

   function coDuongKinh(){
      var danhmuc = document.getElementById("danhmuc").value;
      var coduongkinh = document.getElementById("coduongkinh");

      if(danhmuc == "3"){
     diameterGroup.style.display="block";
      }
      else{
         diameterGroup.style.display = "none";
          document.getElementById("duongkinh").value = "";
      }
   }
     $(document).ready(function() {
      console.log("jQuery is working");
      $('.collapse').on('show.bs.collapse', function () {
          console.log("Mở menu: " + $(this).attr('id'));
      });
      $('.collapse').on('hide.bs.collapse', function () {
          console.log("Đóng menu: " + $(this).attr('id'));
      });
  });
</script>