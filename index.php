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
        <link rel="stylesheet" href="style/main.css">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
            crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <h2 class="title">Korzyści ze współpracy z nami</h2>
            <div class="row">
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/box.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Przechowywanie towarów ponadgabarytowych</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/por2.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Elastyczne warunki współpracy</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/site3.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Integracja i zarządzanie zamówieniami</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/job4.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Wysyłka zamówień w dniu kompletacji</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/mon5.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Niskie koszty dostawy</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/ref6.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Gwarancja bezpieczeństwa towarów</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/cam7.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Całodobowy wideo monitoring</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-12 col-md-3 mbb">
                    <div class="imcard w-90">
                        <div class="icons ">
                            <img src="/assets/wor8.svg" alt="">
                        </div>
                        <div class="desc">
                            <p>Wysyłka zamówień do różnych krajów</p>
                        </div>
                        <span class="water">Opis</span>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="container">
            <h2 class="title">Определение страны по номеру телефона</h2>
            <form method="post">

                <div class="card p-5">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input
                                type="text"
                                id="phone_number"
                                class="form-control"
                                name="phone_number"
                                value="<?php echo $phoneNumber; ?>"
                                placeholder="Введите номер телефона">
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-success" value="Определить страну">
                        </div>

                        <div class="col-md-12 mt-3">
                            <?php echo $result; ?>
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <div class="cookie-popup" id="cookiePopup">
            <p>На этом сайте используются куки.</p>
            <button class="btn btn-success" id="acceptCookies">Принять</button>
            <button class="btn btn-danger" id="closeCookiePopup">Закрыть</button>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
        <script src="js/cookie.js"></script>

    </body>

</html>