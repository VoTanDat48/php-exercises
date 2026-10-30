<?php
//1. Ket noi CSDL kieu thu tuc
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

// Định nghĩa class pager để xử lý phân trang theo yêu cầu bài học[cite: 13]
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
$limit = 5; // Số dòng trên mỗi trang
$start = $p->findStart($limit);
$curPage = isset($_GET['page']) ? $_GET['page'] : 1;

// 2. Lấy tổng số lượng bản ghi để tính số trang
$query_count = "SELECT COUNT(*) AS total FROM sua";
$result_count = mysqli_query($conn, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$count = $row_count['total'];
$pages = $p->findPages($count, $limit);

// 3. Truy vấn dữ liệu có phân trang (Đã sửa loi_sua thành loai_sua cho đúng với CSDL của bạn)
$query = "SELECT s.Ten_sua, h.Ten_hang_sua, l.Ten_loai, s.Trong_luong, s.Don_gia 
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
    <title>Thông tin sữa - Phân trang</title>
    <style>
        table {
            width: 850px;
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        th {
            background-color: #FEE0C1;
            color: #9c0006; 
            text-align: center;
            padding: 8px;
            border: 1px solid #999;
        }
        td {
            padding: 8px;
            border: 1px solid #999;
        }
        tr:nth-child(even) {
            background-color: white;
            color: #BC1C72; 
        }
        tr:nth-child(odd) {
            background-color: #FEE0C1; 
        }
        h2 {
            text-align: center;
            color: #9c0006;
            font-family: Arial, sans-serif;
            font-style: italic;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        .pagination a, .pagination b {
            color: #c00000;
            padding: 5px 8px;
            text-decoration: none;
            margin: 0 2px;
        }
        .pagination b {
            border: 1px solid #ccc;
            background-color: #fcd5b4;
        }
    </style>
</head>
<body>

    <h2>THÔNG TIN SỮA</h2>

    <?php
    if (mysqli_num_rows($result) != 0) {
        echo "<table>";
        echo "<tr>
                <th>Số TT</th>
                <th>Tên sữa</th>
                <th>Hãng sữa</th>
                <th>Loại sữa</th>
                <th>Trọng lượng</th>
                <th>Đơn giá</th>
              </tr>";

        $stt = $start + 1; 
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td align='center'>" . $stt++ . "</td>";
            echo "<td>" . $row['Ten_sua'] . "</td>";
            echo "<td>" . $row['Ten_hang_sua'] . "</td>";
            echo "<td>" . $row['Ten_loai'] . "</td>";
            echo "<td align='center'>" . $row['Trong_luong'] . " gram</td>";
            

            $don_gia = number_format($row['Don_gia'], 0, ',', '.') . " VNĐ";
            echo "<td align='right'>" . $don_gia . "</td>";
            
            echo "</tr>";
        }

        echo "</table>";
    }


    echo "<div class='pagination'>";
    echo $p->pageList($curPage, $pages);
    echo "</div>";


    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>