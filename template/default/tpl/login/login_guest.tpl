
<form id="loginForm">

  Логин:
  <input type="text" name="login" value="admin">
  <br>
  Пароль:
  <input type="text" name="password" value="admin">
  <br>
  <br>

  <input type="hidden" name="event" value="LOGIN">

  <div class="but" onclick="octetFORM.send('loginForm')">Войти</div>

</form>


<div id="request" class="container">тут будет ответ сервера</div>


<script type="text/javascript">

  doc = document;

  octetFORM = {

    formEl:false,
    requestContainerId:'request',

    send:function(formId) {

      this.formEl = doc.getElementById(formId);

      var param=$(this.formEl).serializeArray();


      $.post('/', param, function(data){

        if (data.substring(0,1) == '0') {

          var mess = 'Вы успешно вошли!';
          $('#loginForm').html('Поздравляем!');

          $('#menu_wrap').load('/menu?ajax=1');

        } else {

          var mess = 'Такой пары логин/пароль не найдено!';

        }

        doc.getElementById(octetFORM.requestContainerId).innerHTML = data + ': ' + '<div style="position:relative;display:inline-block;z-index:20;background:inherit">' + mess + '</div>';

      });


    }

  }

</script>