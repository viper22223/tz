<?php
// Get json
function loadPhoneCodes() {
    $url = "https://cdn.jsdelivr.net/gh/andr-04/inputmask-multi@master/data/phone-codes.json";
    $json = file_get_contents($url);
    return json_decode($json, true);
}

// Функция для определения страны по номеру телефона
function detectCountry($phoneNumber) {
    $phoneCodes = loadPhoneCodes();
    $countryCode = "";

    foreach ($phoneCodes as $code) {
        $pattern = str_replace("#", "\\d", preg_quote($code['mask'], '/'));
        if (preg_match("/^$pattern$/", $phoneNumber)) {
            $countryCode = $code['cc'];
            break;
        }
    }

    if ($countryCode !== "") {
        foreach ($phoneCodes as $code) {
            if ($code['cc'] === $countryCode) {
                return [
                    'country_code' => $countryCode,
                    'country_name_en' => $code['name_en'],
                    'country_name_ru' => $code['name_ru']
                ];
            }
        }
    }

    return [
        'country_code' => "Неизвестно",
        'country_name_en' => "Неизвестно",
        'country_name_ru' => "Неизвестно"
    ];
}

// Пример использования
$phoneNumber = "+375(29)123-45-67"; // Телефонный номер для проверки
$result = detectCountry($phoneNumber);

echo "Страна: " . $result['country_name_ru'] . " (" . $result['country_code'] . ")";
?>
