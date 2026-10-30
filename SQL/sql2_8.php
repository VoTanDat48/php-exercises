<?php
//1. Kết nối CSDL kiểu thủ tục
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua"; 
$conn = mysqli_connect($severname, $username, $password, $dbname);

//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// Định nghĩa class pager để xử lý phân trang
class Pager {
    public function findStart($limit) {
        if (!isset($_GET['page']) || $_GET['page'] == 1) {
            $start = 0;
            $_GET['page'] = 1;
        } else {
            $start = ($_GET['page'] - 1) * $limit;
        }
        return $start;
    }

    public function findPages($count, $limit) {
        $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
        return $pages;
    }

    public function pageList($curPage, $pages) {
        $page_list = "";
        // Nút lùi về trước (<)
        if ($curPage > 1) {
            $prev = $curPage - 1;
            $page_list .= "<a href='" . $_SERVER['PHP_SELF'] . "?page=1'>&lt;&lt;</a> ";
            $page_list .= "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $prev . "'>&lt;</a> ";
        }

        // Vòng lặp in các số trang
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == $curPage) {
                $page_list .= "<b>" . $i . "</b> ";
            } else {
                $page_list .= "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "'>" . $i . "</a> ";
            }
        }

        // Nút tiến tới sau (>)
        if ($curPage < $pages) {
            $next = $curPage + 1;
            $page_list .= "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $next . "'>&gt;</a> ";
            $page_list .= "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $pages . "'>&gt;&gt;</a>";
        }
        return $page_list;
    }
}

$p = new Pager();
$limit = 2; // Yêu cầu: Hai sản phẩm một trang
$start = $p->findStart($limit);
$curPage = isset($_GET['page']) ? $_GET['page'] : 1;

// 2. Lấy tổng số lượng bản ghi để tính số trang
$query_count = "SELECT COUNT(*) AS total FROM sua";
$result_count = mysqli_query($conn, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$count = $row_count['total'];
$pages = $p->findPages($count, $limit);

// 3. Truy vấn dữ liệu có phân trang kết hợp bảng hãng sữa và loại sữa
$query = "SELECT s.*, h.Ten_hang_sua, l.Ten_loai 
          FROM sua s 
          JOIN hang_sua h ON s.Ma_hang_sua = h.Ma_hang_sua 
          JOIN loai_sua l ON s.Ma_loai_sua = l.Ma_loai_sua 
          LIMIT $start, $limit";

$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông tin chi tiết các loại sữa - Phân trang</title>
    <style>
        h2 {
            text-align: center;
            color: #F9314D;
            font-family: Arial, sans-serif;
            font-style: italic;
        }
        .detail-table {
            width: 750px;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border: 2px solid #978F8A; 
        }
        .detail-header {
            background-color: #fef0e6;
            color: #F96801; 
            text-align: center;
            padding: 10px;
            font-size: 20px;
            font-style: italic;
            font-weight: bold;
            border-bottom: 2px solid #978F8A;
        }
        .detail-content td {
            padding: 12px;
            vertical-align: top;
            border: 1px solid #978F8A;
        }
        .img-box {
            text-align: center;
            width: 30%;
        }
        .img-box img {
            width: 150px;
            height: auto;
            object-fit: contain;
        }
        .info-box {
            width: 70%;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }
        .section-title {
            color: black;
            font-weight: bold;
            font-style: italic;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .price-weight {
            text-align: left; /* Đã đổi từ right sang left để nằm bên trái */
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }
        /* Định dạng màu chữ riêng cho các con số (giá tiền và trọng lượng) */
        .price-weight .highlight-num {
            color: #9B3957;
        }
        .pagination {
            text-align: center;
            margin: 25px 0;
            font-family: Arial, sans-serif;
        }
        .pagination a, .pagination b {
            color: #0000FF;
            padding: 3px 6px;
            text-decoration: none;
            margin: 0 2px;
        }
        .pagination b {
            color: #0000FF;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>THÔNG TIN CHI TIẾT CÁC LOẠI SỮA</h2>

    <?php
    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<table class='detail-table'>";
            
            // Tiêu đề: Tên sữa - Tên hãng sữa
            echo "<tr>";
            echo "<th colspan='2' class='detail-header'>" . $row['Ten_sua'] . " - " . $row['Ten_hang_sua'] . "</th>";
            echo "</tr>";
            
            echo "<tr class='detail-content'>";
            
            // Cột hình ảnh sản phẩm
            echo "<td class='img-box'>";
            echo "<img src='../Hinh_sua/" . trim($row['Hinh']) . "' alt='" . $row['Ten_sua'] . "'>";
            echo "</td>";
            
            // Cột thông tin chi tiết
            echo "<td class='info-box'>";
            echo "<div class='section-title'>Thành phần dinh dưỡng:</div>";
            echo "<div>" . $row['TP_Dinh_Duong'] . "</div>";
            
            echo "<div class='section-title' style='margin-top: 10px;'>Lợi ích:</div>";
            echo "<div>" . $row['Loi_ich'] . "</div>";
            
            // Bao bọc các con số trọng lượng và đơn giá trong thẻ span có class .highlight-num để đổi màu #9B3957
            echo "<div class='price-weight'>";
            echo "Trọng lượng: <span class='highlight-num'>" . $row['Trong_luong'] . " gr</span> &nbsp;-&nbsp; Đơn giá: <span class='highlight-num'>" . number_format($row['Don_gia'], 0, ',', '.') . " VNĐ</span>";
            echo "</div>";
            
            echo "</td>";
            
            echo "</tr>";
            echo "</table>";
        }
    }

    // Hiển thị danh sách số trang phân trang ở dưới cùng
    echo "<div class='pagination'>";
    echo $p->pageList($curPage, $pages);
    echo "</div>";

    // Xóa kết quả và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>