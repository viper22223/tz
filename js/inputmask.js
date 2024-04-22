document.getElementById('phoneForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    var phoneNumber = document.getElementById('phoneNumber').value;

    // Отправляем запрос на сервер для определения страны
    fetch('api/api.php?phoneNumber=' + phoneNumber)
        .then(response => response.text())
        .then(data => {
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
});