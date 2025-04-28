-- Tạo cơ sở dữ liệu
CREATE DATABASE b03db;


-- Bảng LoaiSanPham
CREATE TABLE LoaiSanPham (
    MaLoai VARCHAR(10) PRIMARY KEY,  -- Mã loại có thể là L01, L02...
    TenLoai VARCHAR(50) NOT NULL,
    HinhAnh TEXT
);

-- Bảng SanPham
CREATE TABLE SanPham (
    MaSanPham VARCHAR(10) PRIMARY KEY, -- Mã sản phẩm có thể là SP001, SP002...
    TenSanPham VARCHAR(100) NOT NULL,
    HuongVi VARCHAR(50),
    DonGia DECIMAL(10,2) NOT NULL,
    DienGiai TEXT,
    TinhTrang BOOLEAN DEFAULT TRUE, -- TRUE: Đang bán, FALSE: Ngừng bán
    HinhAnh TEXT,
    MaLoai VARCHAR(10),
    FOREIGN KEY (MaLoai) REFERENCES LoaiSanPham(MaLoai) ON DELETE CASCADE
);

-- Bảng NguoiDung (quản lý Admin & Khách hàng)
CREATE TABLE NguoiDung (
    TenNguoiDung VARCHAR(50) PRIMARY KEY, -- Username
    MatKhau VARCHAR(255) NOT NULL,
    HoTen VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE,
    SoDienThoai VARCHAR(15) UNIQUE,
    VaiTro ENUM('Admin', 'Customer') NOT NULL,
    TinhTrang ENUM('Khóa', 'Mở') DEFAULT 'Mở',
    TPTinh VARCHAR(50),
    QuanHuyen VARCHAR(50),
    PhuongXa VARCHAR(50),
    DiaChiCuThe TEXT
);

-- Bảng HoaDon (quản lý đơn hàng)
CREATE TABLE HoaDon (
    MaHoaDon VARCHAR(15) PRIMARY KEY, -- Mã hóa đơn có thể là HD001, HD002...
    NguoiNhanHang VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    TPTinh VARCHAR(50),
    QuanHuyen VARCHAR(50),
    PhuongXa VARCHAR(50),
    DiaChiCuThe TEXT,
    NgayGio DATETIME DEFAULT CURRENT_TIMESTAMP,
    TongTien DECIMAL(10,2) NOT NULL,
    TrangThai ENUM('Chưa xác nhận', 'Đã xác nhận', 'Đã giao thành công', 'Đã hủy') NOT NULL DEFAULT 'Chưa xác nhận',
    HinhThucThanhToan VARCHAR(50) NOT NULL, -- Ví dụ: "Tiền mặt", "Chuyển khoản"
    TenNguoiDung VARCHAR(50), -- Khách đặt hàng
    FOREIGN KEY (TenNguoiDung) REFERENCES NguoiDung(TenNguoiDung)
);

-- Bảng ChiTietHoaDon (chi tiết sản phẩm trong đơn hàng)
CREATE TABLE ChiTietHoaDon (
    MaHoaDon VARCHAR(15),
    MaSanPham VARCHAR(10),
    SoLuong INT NOT NULL,
    DonGia DECIMAL(10,2) NOT NULL, -- Giá tại thời điểm mua
    PRIMARY KEY (MaHoaDon, MaSanPham),
    FOREIGN KEY (MaHoaDon) REFERENCES HoaDon(MaHoaDon) ON DELETE CASCADE,
    FOREIGN KEY (MaSanPham) REFERENCES SanPham(MaSanPham)
);


INSERT INTO LoaiSanPham (MaLoai, TenLoai, HinhAnh)
VALUES 
    ('L01', 'Kem ốc quế', 'kemOcQue.jpg'),
    ('L02', 'Kem que', 'kemQue.jpg'),
    ('L03', 'Kem ly','kemLy.jpg');



-- Kem ốc quế (L01)
INSERT INTO SanPham (MaSanPham, TenSanPham, HuongVi, DonGia, DienGiai, TinhTrang, HinhAnh, MaLoai)
VALUES 
('SP001', 'Kem ốc quế dâu', 'Dâu', 15000, 'Kem ốc quế vị dâu tươi', 1, 'kemOcQueDau.jpg', 'L01'),
('SP002', 'Kem ốc quế sô cô la', 'Sô cô la', 15000, 'Kem ốc quế vị sô cô la đậm đà', 1, 'kemOcQueSocola.jpg', 'L01'),
('SP003', 'Kem ốc quế vani', 'Vani', 15000, 'Kem ốc quế vị vani thơm ngon', 1, 'kemOcQueVani.jpg', 'L01'),
('SP004', 'Kem ốc quế xoài', 'Xoài', 15000, 'Kem ốc quế vị xoài nhiệt đới', 1, 'kemOcQueXoai.jpg', 'L01'),
('SP005', 'Kem ốc quế trà xanh', 'Trà xanh', 16000, 'Kem ốc quế vị trà xanh mát lạnh', 1, 'kemOcQueTraXanh.jpg', 'L01'),
('SP006', 'Kem ốc quế dừa', 'Dừa', 15000, 'Kem ốc quế vị dừa béo thơm', 1, 'kemOcQueDua.jpg', 'L01'),
('SP007', 'Kem ốc quế khoai môn', 'Khoai môn', 15000, 'Kem ốc quế vị khoai môn bùi béo', 1, 'kemOcQueKhoaiMon.jpg', 'L01'),
('SP008', 'Kem ốc quế việt quất', 'Việt quất', 16000, 'Kem ốc quế vị việt quất chua ngọt', 1, 'kemOcQueVietQuat.jpg', 'L01'),
('SP009', 'Kem ốc quế caramel', 'Caramel', 16000, 'Kem ốc quế vị caramel ngọt ngào', 0, 'kemOcQueCaramel.jpg', 'L01'),
('SP010', 'Kem ốc quế matcha đậu đỏ', 'Matcha đậu đỏ', 16000, 'Kem ốc quế vị matcha và đậu đỏ truyền thống', 0, 'kemOcQueMatchaDauDo.jpg', 'L01'),

-- Kem que (L02)
('SP011', 'Kem que dâu', 'Dâu', 12000, 'Kem que vị dâu mát lạnh', 1, 'kemQueDau.jpg', 'L02'),
('SP012', 'Kem que sô cô la', 'Sô cô la', 12000, 'Kem que vị sô cô la ngọt ngào', 1, 'kemQueSocola.jpg', 'L02'),
('SP013', 'Kem que vani', 'Vani', 12000, 'Kem que vị vani truyền thống', 1, 'kemQueVani.jpg', 'L02'),
('SP014', 'Kem que xoài', 'Xoài', 12000, 'Kem que vị xoài nhiệt đới', 1, 'kemQueXoai.jpg', 'L02'),
('SP015', 'Kem que trà xanh', 'Trà xanh', 13000, 'Kem que vị trà xanh đậm vị', 1, 'kemQueTraXanh.jpg', 'L02'),
('SP016', 'Kem que dừa', 'Dừa', 12000, 'Kem que vị dừa thanh mát', 1, 'kemQueDua.jpg', 'L02'),
('SP017', 'Kem que khoai môn', 'Khoai môn', 12000, 'Kem que vị khoai môn lạ miệng', 1, 'kemQueKhoaiMon.jpg', 'L02'),
('SP018', 'Kem que việt quất', 'Việt quất', 13000, 'Kem que vị việt quất tươi mát', 1, 'kemQueVietQuat.jpg', 'L02'),
('SP019', 'Kem que caramel', 'Caramel', 13000, 'Kem que vị caramel béo ngậy', 0, 'kemQueCaramel.jpg', 'L02'),
('SP020', 'Kem que matcha đậu đỏ', 'Matcha đậu đỏ', 13000, 'Kem que matcha kết hợp đậu đỏ', 0, 'kemQueMatchaDauDo.jpg', 'L02'),

-- Kem ly (L03)
('SP021', 'Kem ly dâu', 'Dâu', 20000, 'Kem ly vị dâu tươi', 1, 'kemLyDau.jpg', 'L03'),
('SP022', 'Kem ly sô cô la', 'Sô cô la', 20000, 'Kem ly vị sô cô la béo ngậy', 1, 'kemLySocola.jpg', 'L03'),
('SP023', 'Kem ly vani', 'Vani', 20000, 'Kem ly vị vani hảo hạng', 1, 'kemLyVani.jpg', 'L03'),
('SP024', 'Kem ly xoài', 'Xoài', 20000, 'Kem ly vị xoài mát lạnh', 1, 'kemLyXoai.jpg', 'L03'),
('SP025', 'Kem ly trà xanh', 'Trà xanh', 21000, 'Kem ly vị trà xanh Nhật Bản', 1, 'kemLyTraXanh.jpg', 'L03'),
('SP026', 'Kem ly dừa', 'Dừa', 20000, 'Kem ly vị dừa béo thơm', 1, 'kemLyDua.jpg', 'L03'),
('SP027', 'Kem ly khoai môn', 'Khoai môn', 20000, 'Kem ly vị khoai môn tím lịm', 1, 'kemLyKhoaiMon.jpg', 'L03'),
('SP028', 'Kem ly việt quất', 'Việt quất', 21000, 'Kem ly vị việt quất tự nhiên', 1, 'kemLyVietQuat.jpg', 'L03'),
('SP029', 'Kem ly caramel', 'Caramel', 21000, 'Kem ly vị caramel ngọt ngào', 0, 'kemLyCaramel.jpg', 'L03'),
('SP030', 'Kem ly matcha đậu đỏ', 'Matcha đậu đỏ', 21000, 'Kem ly matcha kết hợp đậu đỏ thơm ngon', 0, 'kemLyMatchaDauDo.jpg', 'L03');



-- 3 tài khoản Admin
INSERT INTO NguoiDung (TenNguoiDung, MatKhau, HoTen, Email, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe)
VALUES
('admin1', '$2b$12$aKaT9vYvxDimjrfh3Mm0R.y54R1q9qVWsYijc4osCJYnEmIL8gzHO', 'Nguyễn Văn A', 'admin1@example.com', '0900000001', 'Admin', 'Mở', 'TP. Hồ Chí Minh', 'Quận 1', 'Phường Bến Nghé', '123 Lê Lợi'),
('admin2', '$2b$12$y7hUuYWyX55yVjsR9XdKQ.eY8BG.t1YbOHAT8ZKE62vHCiEd8gN.O', 'Trần Thị B', 'admin2@example.com', '0900000002', 'Admin', 'Mở', 'TP. Hồ Chí Minh', 'Quận 3', 'Phường Võ Thị Sáu', '456 Nguyễn Đình Chiểu'),
('admin3', '$2b$12$omBaODI1OLd/LNszs4aRgOQztCwTh/8G9urnU/uKLCdL.6VBweL3m', 'Lê Văn C', 'admin3@example.com', '0900000003', 'Admin', 'Mở', 'TP. Hồ Chí Minh', 'Quận 5', 'Phường 6', '789 Trần Hưng Đạo');

-- 10 tài khoản Customer
INSERT INTO NguoiDung (TenNguoiDung, MatKhau, HoTen, Email, SoDienThoai, VaiTro, TinhTrang, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe)
VALUES
('user1', '$2b$12$nx2mLh2uDF0O9NReFQb23ecpvH0QfYEx6YUtqHsTZ./QvcLBWIjYy', 'Ngô Thanh Bình', 'user1@example.com', '0900001001', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận 10', 'Phường 12', '12 Tô Hiến Thành'),
('user2', '$2b$12$dwH8hPEGt6a/gC59XLwCp.4II1izfBqrnFOiTzH1.JPc5I9akUY9O', 'Phan Văn Dũng', 'user2@example.com', '0900001002', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận 7', 'Phường Tân Phong', '88 Nguyễn Văn Linh'),
('user3', '$2b$12$5MyZ2pHrPpnJOvG3mMqAnO1FLGPd8ZZooVuJKGw4jacl4xorDk8QG', 'Lưu Thị Hồng', 'user3@example.com', '0900001003', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận Bình Thạnh', 'Phường 25', '102 Điện Biên Phủ'),
('user4', '$2b$12$H/Rwdsy.YlvkfyadCG4xT.Ts8UaxXZhXij/vo4cPk.5RRZE5G4ZtW', 'Đặng Minh Châu', 'user4@example.com', '0900001004', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận Tân Bình', 'Phường 2', '56 Trường Chinh'),
('user5', '$2b$12$f/m5r.JrpDF1gUb7POhEX.rEaj.TKGOCACPdx1HXmhTAswlRYEWQu', 'Nguyễn Thị Lan', 'user5@example.com', '0900001005', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận Phú Nhuận', 'Phường 9', '23 Nguyễn Kiệm'),
('user6', '$2b$12$IjMHtWelKxO98CLP.jSTfuElnrpFntNM9nOrA4zqrwQ5oMumJDIxe', 'Võ Quốc Toàn', 'user6@example.com', '0900001006', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận 6', 'Phường 1', '67 Hậu Giang'),
('user7', '$2b$12$rzn7iDKpDxV6ZsG.taBZe.VMCVlhNLB2sJxBmwbLW2Kb1xbiWtgkC', 'Hồ Thị Mai', 'user7@example.com', '0900001007', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận 11', 'Phường 16', '75 Lạc Long Quân'),
('user8', '$2b$12$yCVAp2IDiWChXOhneo4dcelXP.0IYaY.MsIEauZCB5fULs93cImJK', 'Bùi Văn Hậu', 'user8@example.com', '0900001008', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận Thủ Đức', 'Phường Linh Trung', '90 Võ Văn Ngân'),
('user9', '$2b$12$5AFhRaloYByPzEMZ3dNQTuI5NFJSkr1eQUl98M/2FQacGPv.VQ6B2', 'Đỗ Ngọc Trinh', 'user9@example.com', '0900001009', 'Customer', 'Mở', 'TP. Hồ Chí Minh', 'Quận Bình Tân', 'Phường Bình Hưng Hòa', '37 Tên Lửa'),
('user10', '$2b$12$fHqFKM/apXpI8GUgw18nzOHZc10FKgfs6AhqWO3yVQIrs8PlQGLzO', 'Lý Văn Phúc', 'user10@example.com', '0900001010', 'Customer', 'Khóa', 'TP. Hồ Chí Minh', 'Huyện Nhà Bè', 'Xã Phước Kiển', '18 Nguyễn Hữu Thọ');





-- 30 Đơn hàng với ít nhất 6 người mua hàng khác nhau
INSERT INTO HoaDon (MaHoaDon, NguoiNhanHang, Email, TPTinh, QuanHuyen, PhuongXa, DiaChiCuThe, NgayGio, TongTien, TrangThai, HinhThucThanhToan, TenNguoiDung)
VALUES
('HD001', 'Ngô Thanh Bình', 'user1@example.com', 'TP.HCM', 'Quận 1', 'Phường Bến Nghé', 'Số 1, Nguyễn Văn Cừ', '2025-04-10 10:00:00', 150000, 'Chưa xác nhận', 'Tiền mặt', 'user1'),
('HD002', 'Phan Văn Dũng', 'user2@example.com', 'TP.HCM', 'Quận 2', 'Phường An Khánh', 'Số 15, Lê Văn Lương', '2025-04-11 11:30:00', 180000, 'Chưa xác nhận', 'Chuyển khoản', 'user2'),
('HD003', 'Lưu Thị Hồng', 'user3@example.com', 'TP.HCM', 'Quận 3', 'Phường Võ Thị Sáu', 'Số 20, Lý Chính Thắng', '2025-04-12 09:45:00', 120000, 'Chưa xác nhận', 'Tiền mặt', 'user3'),
('HD004', 'Đặng Minh Châu', 'user4@example.com', 'TP.HCM', 'Quận 4', 'Phường 13', 'Số 22, Đoàn Văn Bơ', '2025-04-13 08:20:00', 220000, 'Đã xác nhận', 'Tiền mặt', 'user4'),
('HD005', 'Nguyễn Thị Lan', 'user5@example.com', 'TP.HCM', 'Quận 5', 'Phường 8', 'Số 5, An Dương Vương', '2025-04-14 12:00:00', 250000, 'Đã xác nhận', 'Chuyển khoản', 'user5'),
('HD006', 'Võ Quốc Toàn', 'user6@example.com', 'TP.HCM', 'Quận 6', 'Phường 10', 'Số 10, Bà Hom', '2025-04-15 10:30:00', 190000, 'Đã xác nhận', 'Tiền mặt', 'user6'),
('HD007', 'Hồ Thị Mai', 'user7@example.com', 'TP.HCM', 'Quận 7', 'Phường Tân Phong', 'Số 35, Nguyễn Văn Linh', '2025-04-16 11:45:00', 170000, 'Đã xác nhận', 'Chuyển khoản', 'user7'),
('HD008', 'Bùi Văn Hậu', 'user8@example.com', 'TP.HCM', 'Quận 8', 'Phường 7', 'Số 40, Phạm Thế Hiển', '2025-04-17 09:30:00', 130000, 'Đã giao thành công', 'Tiền mặt', 'user8'),
('HD009', 'Đỗ Ngọc Trinh', 'user9@example.com', 'TP.HCM', 'Quận 9', 'Phường Tăng Nhơn Phú', 'Số 12, Lê Văn Việt', '2025-04-18 14:10:00', 210000, 'Đã giao thành công', 'Chuyển khoản', 'user9'),
('HD010', 'Lý Văn Phúc', 'user10@example.com', 'TP.HCM', 'Quận 10', 'Phường 5', 'Số 55, Hòa Hưng', '2025-04-19 08:50:00', 180000, 'Đã giao thành công', 'Tiền mặt', 'user10'),
('HD011', 'Ngô Thanh Bình', 'user1@example.com', 'TP.HCM', 'Quận 1', 'Phường Bến Nghé', 'Số 1, Nguyễn Văn Cừ', '2025-04-20 12:00:00', 190000, 'Đã giao thành công', 'Chuyển khoản', 'user1'),
('HD012', 'Phan Văn Dũng', 'user2@example.com', 'TP.HCM', 'Quận 2', 'Phường An Khánh', 'Số 15, Lê Văn Lương', '2025-04-21 11:30:00', 250000, 'Đã giao thành công', 'Tiền mặt', 'user2'),
('HD013', 'Lưu Thị Hồng', 'user3@example.com', 'TP.HCM', 'Quận 3', 'Phường Võ Thị Sáu', 'Số 20, Lý Chính Thắng', '2025-04-22 09:45:00', 220000, 'Đã giao thành công', 'Chuyển khoản', 'user3'),
('HD014', 'Đặng Minh Châu', 'user4@example.com', 'TP.HCM', 'Quận 4', 'Phường 13', 'Số 22, Đoàn Văn Bơ', '2025-04-23 08:20:00', 210000, 'Đã giao thành công', 'Tiền mặt', 'user4'),
('HD015', 'Nguyễn Thị Lan', 'user5@example.com', 'TP.HCM', 'Quận 5', 'Phường 8', 'Số 5, An Dương Vương', '2025-04-24 12:00:00', 150000, 'Đã giao thành công', 'Chuyển khoản', 'user5'),
('HD016', 'Võ Quốc Toàn', 'user6@example.com', 'TP.HCM', 'Quận 6', 'Phường 10', 'Số 10, Bà Hom', '2025-04-25 10:30:00', 170000, 'Đã giao thành công', 'Tiền mặt', 'user6'),
('HD017', 'Hồ Thị Mai', 'user7@example.com', 'TP.HCM', 'Quận 7', 'Phường Tân Phong', 'Số 35, Nguyễn Văn Linh', '2025-04-26 11:45:00', 160000, 'Đã giao thành công', 'Chuyển khoản', 'user7'),
('HD018', 'Bùi Văn Hậu', 'user8@example.com', 'TP.HCM', 'Quận 8', 'Phường 7', 'Số 40, Phạm Thế Hiển', '2025-04-27 09:30:00', 130000, 'Đã giao thành công', 'Tiền mặt', 'user8'),
('HD019', 'Đỗ Ngọc Trinh', 'user9@example.com', 'TP.HCM', 'Quận 9', 'Phường Tăng Nhơn Phú', 'Số 12, Lê Văn Việt', '2025-04-28 14:10:00', 230000, 'Đã giao thành công', 'Chuyển khoản', 'user9'),
('HD020', 'Lý Văn Phúc', 'user10@example.com', 'TP.HCM', 'Quận 10', 'Phường 5', 'Số 55, Hòa Hưng', '2025-04-29 08:50:00', 210000, 'Đã hủy', 'Tiền mặt', 'user10'),
('HD021', 'Ngô Thanh Bình', 'user1@example.com', 'TP.HCM', 'Quận 1', 'Phường Bến Nghé', 'Số 1, Nguyễn Văn Cừ', '2025-05-01 10:00:00', 160000, 'Đã hủy', 'Chuyển khoản', 'user1'),
('HD022', 'Phan Văn Dũng', 'user2@example.com', 'TP.HCM', 'Quận 2', 'Phường An Khánh', 'Số 15, Lê Văn Lương', '2025-05-02 11:30:00', 200000, 'Đã hủy', 'Tiền mặt', 'user2'),
('HD023', 'Lưu Thị Hồng', 'user3@example.com', 'TP.HCM', 'Quận 3', 'Phường Võ Thị Sáu', 'Số 20, Lý Chính Thắng', '2025-05-03 09:45:00', 180000, 'Đã hủy', 'Chuyển khoản', 'user3'),
('HD024', 'Đặng Minh Châu', 'user4@example.com', 'TP.HCM', 'Quận 4', 'Phường 13', 'Số 22, Đoàn Văn Bơ', '2025-05-04 08:20:00', 210000, 'Đã hủy', 'Tiền mặt', 'user4'),
('HD025', 'Nguyễn Thị Lan', 'user5@example.com', 'TP.HCM', 'Quận 5', 'Phường 8', 'Số 5, An Dương Vương', '2025-05-05 12:00:00', 200000, 'Đã hủy', 'Chuyển khoản', 'user5'),
('HD026', 'Võ Quốc Toàn', 'user6@example.com', 'TP.HCM', 'Quận 6', 'Phường 10', 'Số 10, Bà Hom', '2025-05-06 10:30:00', 210000, 'Đã xác nhận', 'Tiền mặt', 'user6'),
('HD027', 'Hồ Thị Mai', 'user7@example.com', 'TP.HCM', 'Quận 7', 'Phường Tân Phong', 'Số 35, Nguyễn Văn Linh', '2025-05-07 11:45:00', 240000, 'Đã xác nhận', 'Chuyển khoản', 'user7'),
('HD028', 'Bùi Văn Hậu', 'user8@example.com', 'TP.HCM', 'Quận 8', 'Phường 7', 'Số 40, Phạm Thế Hiển', '2025-05-08 09:30:00', 180000, 'Đã xác nhận', 'Tiền mặt', 'user8'),
('HD029', 'Đỗ Ngọc Trinh', 'user9@example.com', 'TP.HCM', 'Quận 9', 'Phường Tăng Nhơn Phú', 'Số 12, Lê Văn Việt', '2025-05-09 14:10:00', 220000, 'Đã xác nhận', 'Chuyển khoản', 'user9'),
('HD030', 'Lý Văn Phúc', 'user10@example.com', 'TP.HCM', 'Quận 10', 'Phường 5', 'Số 55, Hòa Hưng', '2025-05-10 08:50:00', 250000, 'Đã xác nhận', 'Tiền mặt', 'user10');

-- Bảng ChiTietHoaDon (chi tiết sản phẩm trong đơn hàng)
INSERT INTO ChiTietHoaDon (MaHoaDon, MaSanPham, SoLuong, DonGia)
VALUES
('HD001', 'SP001', 2, 50000), ('HD001', 'SP002', 1, 70000), 
('HD002', 'SP022', 3, 70000), ('HD002', 'SP003', 2, 80000), 
('HD003', 'SP003', 1, 80000), ('HD003', 'SP004', 2, 60000),
('HD004', 'SP005', 1, 110000), ('HD004', 'SP006', 1, 120000),
('HD005', 'SP007', 1, 130000), ('HD005', 'SP008', 2, 120000),
('HD006', 'SP019', 2, 95000), ('HD006', 'SP010', 1, 105000),
('HD007', 'SP001', 2, 50000), ('HD007', 'SP011', 1, 85000),
('HD008', 'SP002', 1, 70000), ('HD008', 'SP003', 2, 80000),
('HD009', 'SP004', 1, 60000), ('HD009', 'SP005', 1, 110000),
('HD010', 'SP006', 2, 120000), ('HD010', 'SP007', 1, 130000),
('HD011', 'SP008', 1, 120000), ('HD011', 'SP009', 2, 95000),
('HD012', 'SP010', 2, 105000), ('HD012', 'SP001', 1, 50000),
('HD013', 'SP002', 1, 70000), ('HD013', 'SP003', 2, 80000),
('HD014', 'SP014', 1, 60000), ('HD014', 'SP005', 1, 110000),
('HD015', 'SP006', 2, 120000), ('HD015', 'SP007', 1, 130000),
('HD016', 'SP008', 1, 120000), ('HD016', 'SP009', 2, 95000),
('HD017', 'SP010', 2, 105000), ('HD017', 'SP001', 1, 50000),
('HD018', 'SP002', 3, 70000), ('HD018', 'SP003', 1, 80000),
('HD019', 'SP004', 2, 60000), ('HD019', 'SP025', 1, 110000),
('HD020', 'SP006', 1, 120000), ('HD020', 'SP007', 2, 130000),
('HD021', 'SP008', 1, 120000), ('HD021', 'SP009', 1, 95000),
('HD022', 'SP010', 2, 105000), ('HD022', 'SP001', 1, 50000),
('HD023', 'SP012', 2, 70000), ('HD023', 'SP003', 1, 80000),
('HD024', 'SP004', 1, 60000), ('HD024', 'SP005', 2, 110000),
('HD025', 'SP016', 2, 120000), ('HD025', 'SP007', 1, 130000),
('HD026', 'SP008', 1, 120000), ('HD026', 'SP009', 2, 95000),
('HD027', 'SP010', 2, 105000), ('HD027', 'SP001', 1, 50000),
('HD028', 'SP002', 3, 70000), ('HD028', 'SP003', 2, 80000),
('HD029', 'SP004', 1, 60000), ('HD029', 'SP015', 1, 110000),
('HD030', 'SP006', 2, 120000), ('HD030', 'SP007', 1, 130000);



