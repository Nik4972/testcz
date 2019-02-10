    /* Функция cal()
     * 1. Принимает данные из формы ввода
     * 2. Проверяет валидность количества товара
     * 3. Отправляет данные на сервер через Ajax
     * 4. Получает данные от сервера через Ajax
     * 5. Отправляет полученные данные на главную страницу в поле  c id="results"
     * 6. В случае сбоя при обработке данных сервером, отображает полученные ошибки
    */

    function call() {
          var msg = $('#formx').serialize();
          var kol = $('#kol').val();

     //Проверка валидности количества товара
          if( parseInt(kol) != kol || kol == 0) {
           alert('Неверное количество товара!');
         } else {

            $.ajax({
              type: 'POST',
              url: 'trash.php',
              data: msg,
              success: function(data) {
                $('#results').html(data);
              },
              error:  function(xhr, str){
              alert('Ошибка обработки: ' + xhr.responseCode);
              }
            });
           }
         }



