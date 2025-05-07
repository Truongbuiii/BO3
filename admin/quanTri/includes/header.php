<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang login
if (!isset($_SESSION['adminid'])) {
    header("Location: /admin/quanTri/login.php"); // Đường dẫn điều chỉnh theo cấu trúc thư mục thực tế
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .card {
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .p-5 {
            padding: 40px;
        }

        select.form-control {
            height: 45px;
            line-height: normal;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            appearance: none;
        }

        select.form-control option {
            padding: 10px;
            font-size: 16px;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            color: white;
            background-color: #007bff;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        #imagePreview {
            display: none;
            width: 150px;
            height: 150px;
            margin-top: 10px;
            border-radius: 8px;
            border: 2px solid #ddd;
            padding: 5px;
        }

        h1.h4 {
            font-weight: bold;
            color: #343a40;
        }

        .form-group, .huongVi {
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
        }

        button.btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }

        button.btn-primary:hover {
            background-color: #0056b3;
        }

        img#imagePreview {
            display: none;
            width: 150px;
            margin-top: 10px;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 8px;
            background: #f8f9fa;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

       <?php include('includes/sidebar.php'); ?>

       <!-- Content Wrapper -->
       <div id="content-wrapper" class="d-flex flex-column">

           <!-- Main Content -->
           <div id="content">

               <!-- Topbar -->
               <?php include('topbar.php'); ?>

               <!-- Begin Page Content -->
               <div class="container-fluid">
