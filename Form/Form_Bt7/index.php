<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Phép tính trên hai số</title>
<style>
    body { font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .container { width: 450px; text-align: center; }
    h2 { color: #000080; font-weight: bold; }
    .form-group { margin: 10px 0; text-align: left; display: flex; align-items: center; }
    .form-group label { width: 130px; font-weight: bold; color: blue; }
    .form-group .label-phep-tinh { width: 130px; font-weight: bold; color: #a52a2a; }
    .form-group input[type="text"] { flex: 1; padding: 3px; border: 1px solid #7f7f7f; color: blue; }
    .radio-container { flex: 1; display: flex; gap: 15px; align-items: center; }
    .radio-container label { width: auto; font-weight: normal; color: #a52a2a; cursor: pointer; }
    .btn { margin-top: 15px; }
    .btn input { padding: 3px 15px; background: #e1e1e1; border: 1px solid #7f7f7f; cursor: pointer; }
</style>
</head>
<body>

<div class="container">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>

    <form method="POST" action="ketqua.php">
        <div class="form-group">
            <span class="label-phep-tinh">Chọn phép tính :</span>
            <div class="radio-container">
                <label><input type="radio" name="phep_tinh" value="+" checked> Cộng</label>
                <label><input type="radio" name="phep_tinh" value="-"> Trừ</label>
                <label><input type="radio" name="phep_tinh" value="*"> Nhân</label>
                <label><input type="radio" name="phep_tinh" value="/"> Chia</label>
            </div>
        </div>
        <div class="form-group">
            <label>Số thứ nhất :</label>
            <input type="text" name="so1" required>
        </div>
        <div class="form-group">
            <label>Số thứ nhì :</label>
            <input type="text" name="so2" required>
        </div>
        <div class="btn">
            <input type="submit" value="Tính">
        </div>
    </form>
</div>

</body>
</html>