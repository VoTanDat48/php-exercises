<?php

if (isset($_GET['ajax']) &&$_GET['ajax'] == '1') {
    $from =$_GET['from'] ?? 'USD';
    $to =$_GET['to'] ?? 'VND';
    $amount = floatval($_GET['amount'] ?? 0);

    if ($amount <= 0) {
        echo json_encode([
            'success' => true,
            'query' => ['from' => $from, 'to' =>$to, 'amount' => 0],
            'info' => ['rate' => 0],
            'date' => date('Y-m-d'),
            'result' => 0
        ]);
        exit;
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://currency-conversion-and-exchange-rates.p.rapidapi.com/convert?from={$from}&to={$to}&amount={$amount}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: currency-conversion-and-exchange-rates.p.rapidapi.com",
            "x-rapidapi-key: f84bda94aamsh685e0d9d256a938p167784jsnea3d055c40f4"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo json_encode(['success' => false, 'message' => "cURL Error #: " . $err]);
    } else {
        echo $response;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển đổi ngoại tệ</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f9fa; margin: 0; padding: 40px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { color: #111; margin-bottom: 20px; font-size: 24px; }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 25px; align-items: center; flex-wrap: wrap; }
        .tab-btn { padding: 10px 20px; border-radius: 20px; border: 1px solid #ddd; background: #f1f3f5; cursor: pointer; font-weight: 600; color: #555; transition: all 0.3s; }
        .tab-btn.active { background-color: #72a011; color: white; border-color: #72a011; } 
        
        .update-time { margin-left: auto; font-size: 13px; color: #666; }

        .converter-box { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-top: 20px; }
        .input-group-container { flex: 1; border: 1px solid #dfe3e6; border-radius: 8px; padding: 10px 15px; background: #fff; display: flex; flex-direction: column; }
        .label-text { font-size: 12px; color: #666; margin-bottom: 5px; font-weight: bold; }
        
        .input-row { display: flex; align-items: center; justify-content: space-between; }
        select { border: none; font-size: 16px; font-weight: bold; background: transparent; outline: none; cursor: pointer; }
        input[type="text"] { border: none; font-size: 20px; font-weight: bold; width: 60%; text-align: right; outline: none; background: transparent; }
        
        .arrow-icon { width: 45px; height: 45px; background: #eef6e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #72a011; font-size: 20px; font-weight: bold; flex-shrink: 0; }
        
        .rate-info { margin-top: 25px; font-size: 14px; color: #444; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Chuyển đổi ngoại tệ</h2>
    
    <div class="tabs">
        <button class="tab-btn active">Mua tiền mặt</button>
        
        <div class="update-time" id="update_date">Tỷ giá đang cập nhật...</div>
    </div>

    <div class="converter-box">
        <div class="input-group-container">
            <span class="label-text">SỐ TIỀN QUÝ KHÁCH CẦN BÁN</span>
            <div class="input-row">
                <select id="from_currency" onchange="callApiConvert()">
                    <option value="USD" selected>USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="AUD">AUD</option>
                    <option value="SGD">SGD</option>
                    <option value="JPY">JPY</option>
                </select>
                <input type="text" id="amount" value="0" oninput="validateAndConvert(this)" autocomplete="off">
            </div>
        </div>

        <div class="arrow-icon">→</div>
        <div class="input-group-container" style="background: #fafbfc;">
            <span class="label-text">SỐ TIỀN QUÝ KHÁCH SẼ NHẬN</span>
            <div class="input-row">
                <select id="to_currency" onchange="callApiConvert()">
                    <option value="VND" selected>VND</option>
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                </select>
                <input type="text" id="result" value="0" readonly style="color: #2b7a0b;">
            </div>
        </div>
    </div>

    <div class="rate-info" id="rate_text">
        Đang kết nối tới RapidAPI...
    </div>
</div>

<script>

function validateAndConvert(input) {
    let value = input.value.replace(/[^0-9.]/g, '');
    
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }
    
    input.value = value;
    callApiConvert();
}


function callApiConvert() {
    let amountInput = document.getElementById('amount');
    let amount = amountInput.value.trim();

    if (amount === '' || isNaN(amount) || Number(amount) === 0) {
        document.getElementById('result').value = '0';
        document.getElementById('rate_text').innerHTML = `<strong>Tỷ giá áp dụng:</strong> 0`;
        return;
    }

    let from = document.getElementById('from_currency').value;
    let to = document.getElementById('to_currency').value;

    document.getElementById('rate_text').innerHTML = "Đang gọi API quy đổi...";

    let xhr = new XMLHttpRequest();
    xhr.open('GET', `?ajax=1&from=${from}&to=${to}&amount=${amount}`, true);
    xhr.onload = function() {
        if (this.status === 200) {
            try {
                let res = JSON.parse(this.responseText);
                if (res.success) {
                    document.getElementById('result').value = Number(res.result).toLocaleString('vi-VN', {maximumFractionDigits: 5});
                    document.getElementById('rate_text').innerHTML = `<strong>Tỷ giá chuẩn từ API:</strong> 1 ${res.query.from} = ${res.info.rate} ${res.query.to}`;
                    document.getElementById('update_date').innerHTML = `Tỷ giá được cập nhật lúc ngày ${res.date}`;
                } else {
                    document.getElementById('rate_text').innerHTML = `<span style="color:red;">Lỗi API: ${res.message}</span>`;
                }
            } catch (e) {
                document.getElementById('rate_text').innerHTML = `<span style="color:red;">Lỗi phân tích dữ liệu phản hồi từ API.</span>`;
            }
        }
    };
    xhr.send();
}

window.onload = function() {
    callApiConvert();
};
</script>

</body>
</html>