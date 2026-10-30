<?php
$apiKey = getenv("RAPIDAPI_KEY") ?: "DAN_RAPIDAPI_KEY_CUA_BAN_VAO_DAY";

$names = [
    "af" => "Afrikaans",
    "sq" => "Albanian",
    "am" => "Amharic",
    "ar" => "Arabic",
    "hy" => "Armenian",
    "as" => "Assamese",
    "ay" => "Aymara",
    "az" => "Azerbaijani",
    "bm" => "Bambara",
    "eu" => "Basque",
    "be" => "Belarusian",
    "bn" => "Bengali",
    "bho" => "Bhojpuri",
    "bs" => "Bosnian",
    "bg" => "Bulgarian",
    "ca" => "Catalan",
    "ceb" => "Cebuano",
    "ny" => "Chichewa",
    "zh-CN" => "Chinese (Simplified)",
    "zh-TW" => "Chinese (Traditional)",
    "co" => "Corsican",
    "hr" => "Croatian",
    "cs" => "Czech",
    "da" => "Danish",
    "dv" => "Dhivehi",
    "doi" => "Dogri",
    "nl" => "Dutch",
    "en" => "English",
    "eo" => "Esperanto",
    "et" => "Estonian",
    "ee" => "Ewe",
    "tl" => "Filipino",
    "fi" => "Finnish",
    "fr" => "French",
    "fy" => "Frisian",
    "gl" => "Galician",
    "ka" => "Georgian",
    "de" => "German",
    "el" => "Greek",
    "gn" => "Guarani",
    "gu" => "Gujarati",
    "ht" => "Haitian Creole",
    "ha" => "Hausa",
    "haw" => "Hawaiian",
    "he" => "Hebrew",
    "hi" => "Hindi",
    "hmn" => "Hmong",
    "hu" => "Hungarian",
    "is" => "Icelandic",
    "ig" => "Igbo",
    "ilo" => "Ilocano",
    "id" => "Indonesian",
    "ga" => "Irish",
    "it" => "Italian",
    "ja" => "Japanese",
    "jv" => "Javanese",
    "kn" => "Kannada",
    "kk" => "Kazakh",
    "km" => "Khmer",
    "rw" => "Kinyarwanda",
    "gom" => "Konkani",
    "ko" => "Korean",
    "kri" => "Krio",
    "ku" => "Kurdish (Kurmanji)",
    "ckb" => "Kurdish (Sorani)",
    "ky" => "Kyrgyz",
    "lo" => "Lao",
    "la" => "Latin",
    "lv" => "Latvian",
    "ln" => "Lingala",
    "lt" => "Lithuanian",
    "lg" => "Luganda",
    "lb" => "Luxembourgish",
    "mk" => "Macedonian",
    "mai" => "Maithili",
    "mg" => "Malagasy",
    "ms" => "Malay",
    "ml" => "Malayalam",
    "mt" => "Maltese",
    "mi" => "Maori",
    "mr" => "Marathi",
    "mni-Mtei" => "Meiteilon (Manipuri)",
    "lus" => "Mizo",
    "mn" => "Mongolian",
    "my" => "Myanmar (Burmese)",
    "ne" => "Nepali",
    "no" => "Norwegian",
    "or" => "Odia (Oriya)",
    "om" => "Oromo",
    "ps" => "Pashto",
    "fa" => "Persian",
    "pl" => "Polish",
    "pt" => "Portuguese",
    "pa" => "Punjabi",
    "qu" => "Quechua",
    "ro" => "Romanian",
    "ru" => "Russian",
    "sm" => "Samoan",
    "sa" => "Sanskrit",
    "gd" => "Scots Gaelic",
    "nso" => "Sepedi",
    "sr" => "Serbian",
    "st" => "Sesotho",
    "sn" => "Shona",
    "sd" => "Sindhi",
    "si" => "Sinhala",
    "sk" => "Slovak",
    "sl" => "Slovenian",
    "so" => "Somali",
    "es" => "Spanish",
    "su" => "Sundanese",
    "sw" => "Swahili",
"sv" => "Swedish",
    "tg" => "Tajik",
    "ta" => "Tamil",
    "tt" => "Tatar",
    "te" => "Telugu",
    "th" => "Thai",
    "ti" => "Tigrinya",
    "ts" => "Tsonga",
    "tr" => "Turkish",
    "tk" => "Turkmen",
    "ak" => "Twi",
    "uk" => "Ukrainian",
    "ur" => "Urdu",
    "ug" => "Uyghur",
    "uz" => "Uzbek",
    "vi" => "Vietnamese",
    "cy" => "Welsh",
    "xh" => "Xhosa",
    "yi" => "Yiddish",
    "yo" => "Yoruba",
    "zu" => "Zulu"
];

asort($names);

$languages = array_keys($names);

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
    } elseif ($source === $target) {
        $error = "Ngôn ngữ nguồn và đích đang giống nhau!";
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
                "x-rapidapi-key: " . $apiKey
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

function renderOptions($names, $current)
{
    foreach ($names as $code => $name) {
        $selected = ($current === $code) ? "selected" : "";
        echo "<option value='" . htmlspecialchars($code, ENT_QUOTES, "UTF-8") . "' $selected>"
            . htmlspecialchars($name, ENT_QUOTES, "UTF-8") . "</option>";
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
            width: 170px;
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
                            <?php renderOptions($names, $source); ?>
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
                            <?php renderOptions($names, $target); ?>
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