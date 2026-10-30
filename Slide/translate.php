<?php
$codes = "ab ace ach af ak alz am ar as awa ay az ba ban bbc be bem bew bg bho bik bm bn br bs bts btx bua ca ceb cgg chm ckb cnh co crh crs cs cv cy da de din doi dov dv dz ee el en eo es et eu fa ff fi fj fr fr-CA fy ga gaa gd gl gn gom gu ha haw he hi hil hmn hr hrx ht hu hy id ig ilo is it iw ja jv jw ka kk km kn ko kri ktu ku ky la lb lg li lij lmo ln lo lt ltg luo lus lv mai mak mg mi min mk ml mn mni-Mtei mr ms ms-Arab mt my ne new nl no nr nso nus ny oc om or pa pa-Arab pag pam pap pl ps pt pt-PT qu rn ro rom ru rw sa scn sd sg shn si sk sl sm sn so sq sr ss st su sv sw szl ta te tet tg th ti tk tl tn tr ts tt ug uk ur uz vi xh yi yo yua yue zh zh-CN zh-TW zu";
$languages = ["en", "vi"];

$names = [
    "en" => "English",
    "vi" => "Vietnamese"
];

$source = $_GET["source"] ?? "en";
$target = $_GET["target"] ?? "vi";
$q = $_GET["q"] ?? "Hello Nha Trang University!";
$translated = "";
$error = "";


if (!in_array($source, $languages, true)) {
    $source = "en";
}

if (!in_array($target, $languages, true)) {
    $target = "vi";
}

if (isset($_GET["translate"])) {
    if (trim($q) == "") {
        $error = "Vui lòng nhập văn bản!";
    } else {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://google-translator9.p.rapidapi.com/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                "q" => $q,
                "source" => $source,
                "target" => $target
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "x-rapidapi-host: google-translator9.p.rapidapi.com",
                "x-rapidapi-key: 645897edbdmshfbe73a4d551a55dp14cee8jsnc372403830f5"
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            $error = $err;
        } elseif ($status != 200) {
            $error = "API trả về lỗi HTTP: " . $status;
        } else {
            $array = json_decode($response, true);

            $translated = $array["data"]["translations"][0]["translatedText"] ?? "";

            if ($translated == "") {
                $error = "Không lấy được kết quả dịch!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Translate</title>

    <style>
        .container {
            width: 800px;
            max-width: 95%;
            margin: 30px auto;
            padding: 15px;
            background-color: #f1f1f1;
        }

        table {
            width: 100%;
        }

        td {
            padding: 5px;
        }
        select {
            width: 130px;
            padding: 5px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #00ad7a;
            color: white;
            border: none;
            padding: 15px 30px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">

        <form method="GET">

            <table>
                <tr>
                    <td width="180">
                        <select name="source">
                            <?php
                            foreach ($languages as $code) {
                                $name = $names[$code] ?? $code;
                                $selected = ($source == $code) ? "selected" : "";

                                echo "<option value='$code' $selected>$name</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <td>
                        <textarea name="q"><?php echo htmlspecialchars($q, ENT_QUOTES, "UTF-8"); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button type="submit" name="translate" value="1">
                            Translate
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <select name="target">
                            <?php
                            foreach ($languages as $code) {
                                $name = $names[$code] ?? $code;
                                $selected = ($target == $code) ? "selected" : "";

                                echo "<option value='$code' $selected>$name</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <td>
                        <textarea readonly><?php echo htmlspecialchars($translated, ENT_QUOTES, "UTF-8"); ?></textarea>
                    </td>
                </tr>
            </table>

            <p style="color:red">
                <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
            </p>

        </form>

    </div>

</body>

</html>