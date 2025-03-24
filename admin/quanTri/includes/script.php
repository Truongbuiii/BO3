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

<script>
    function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function () {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.style.display = "block"; // Hiển thị ảnh khi đã chọn file
    };

    if (input.files.length > 0) {
        reader.readAsDataURL(input.files[0]);
        document.getElementById("file-name").textContent = input.files[0].name;
    } else {
        document.getElementById("file-name").textContent = "Chưa có tệp nào";
    }
}

</script>