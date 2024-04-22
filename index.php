<?php
// download json`
$json_url = 'https://cdn.jsdelivr.net/gh/andr-04/inputmask-multi@master/data/phone-codes.json';
$json = file_get_contents($json_url);
$countries = json_decode($json, true);

function detectCountryByPhoneNumber($phoneNumber, $countries)
{
    $phoneNumber = preg_replace('/[^\d\+]/', '', $phoneNumber); // udalyaem simbols krome +

    $code = substr($phoneNumber, 1, 4);

    foreach ($countries as $country) {
        $mask = str_replace('#', '\d', $country['mask']);
        $mask = preg_replace('/[^\d\+]/', '', $mask);
        if (strpos($phoneNumber, $mask) === 0) {
            return [
                'country_code' => $country['cc'],
                'country_name' => $country['name_en']
            ];
        }
    }
    return null; 
}

$phoneNumber = '';
$result = '';

//post method
if (isset($_POST['phone_number'])) {
    $phoneNumber = $_POST['phone_number'];
    //dobalyaem + esli netu
    if ($phoneNumber[0] !== '+') {
        $phoneNumber = '+' . $phoneNumber;
    }
    $country = detectCountryByPhoneNumber($phoneNumber, $countries);
    if ($country) {
        $result = "Номер: $phoneNumber - Страна: {$country['country_name']} (Код страны: {$country['country_code']})";
    } else {
        $result = "Номер: $phoneNumber - Страна не определена";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Определение страны по номеру телефона</title>
</head>

<body>
    <h2>Определение страны по номеру телефона</h2>
    <form method="post">
        <label for="phone_number">Введите номер телефона:</label><br>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $phoneNumber; ?>" placeholder="Введите номер телефона"><br><br>
        <input type="submit" value="Определить страну">
    </form>
    <br>
    <div>
        <?php echo $result; ?>
    </div>
</body>

</html>
