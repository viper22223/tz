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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    
    <div class="container">
    <h2>Определение страны по номеру телефона</h2>
    <form method="post">
        <div class="row mt-3">
       
            <div class="col-md-6">
              <input type="text" id="phone_number" class="form-control"  name="phone_number" value="<?php echo $phoneNumber; ?>" placeholder="Введите номер телефона">
            </div>
        <div class="col-md-6">
         <input type="submit" class="btn btn-success"value="Определить страну">
        </div>
        
        <div class="col-md-12 mt-3">
        <?php echo $result; ?>
    </div>
        </div>
        
    </div>
    </form>
    
   
    <div class="cookie-popup" id="cookiePopup">
        <p>На этом сайте используются куки.</p>
        <button class="btn btn-success" id="acceptCookies">Принять</button>
        <button class="btn btn-danger" id="closeCookiePopup">Закрыть</button>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script>
    // proverka cookies esli 
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    // poluchenie cookie
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // proveryaem cookie
    function checkCookie() {
        var cookiePopup = document.getElementById("cookiePopup");
        var cookieAccepted = getCookie("cookieAccepted");
        if (cookieAccepted) {
            cookiePopup.style.display = "none";
        } else {
            cookiePopup.style.display = "block";
        }
    }

    // zakrivaem i ochishaaem
    document.getElementById("closeCookiePopup").addEventListener("click", function() {
        setCookie("cookieAccepted", "", 1); 
        document.getElementById("cookiePopup").style.display = "none";
    });

    // prinimaem
    document.getElementById("acceptCookies").addEventListener("click", function() {
        setCookie("cookieAccepted", true, 1);
        document.getElementById("cookiePopup").style.display = "none";
    });

    // proverka cookie 
    window.onload = checkCookie;
</script>

</body>

</html>
