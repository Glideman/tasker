
str_to_sha256 = function(string) {
  return sjcl.codec.hex.fromBits( sjcl.hash.sha256.hash(string) );
};



// регистрация на сайте
$('#i-sb-reg-submit-button').click( function(e) {
  e.preventDefault();

  // поля получаю для выделения в случае ошибки
  let input_login = document.getElementById('i-sb-reg-form-input-login');
  let input_name = document.getElementById('i-sb-reg-form-input-name');
  let input_mail = document.getElementById('i-sb-reg-form-input-mail');
  let input_password = document.getElementById('i-sb-reg-form-input-password');
  let input_passconf = document.getElementById('i-sb-reg-form-input-passconf');

  // получаю значения
  let user_login = input_login.value;
  let user_name = input_name.value;
  let user_mail = input_mail.value;
  let user_password = input_password.value;
  let user_passconf = input_passconf.value;

  // TODO валидация на фронте, включая валидацию повтора пароля (она будет ток на фронте)
  let error = false;

  if(! /^[-_а-яёa-z0-9]{3,64}$/i.test(user_login)) {
    input_login.classList.add('sb-form-input-field-er'); error = true;}

  if(! /^[\s-_а-яёa-z0-9]{0,128}$/i.test(user_name)) {
    input_name.classList.add('sb-form-input-field-er'); error = true;}

  if(! /^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,})){0,64}$/.test(user_mail)) {
    input_mail.classList.add('sb-form-input-field-er'); error = true;}

  if(user_password != user_passconf) {
    input_passconf.classList.add('sb-form-input-field-er'); error = true;}

  let password_hash = str_to_sha256(user_password);

  // если валидация на фронте пройдена, посылаем на сервер
  if(error === false) {
    $.ajax({
      type: 'post',
      url: 'user/register',
      data: {'login':user_login, 'pass':password_hash, 'name':user_name, 'mail':user_mail},
      dataType: 'script'
    });
  }
});



// логин на сайт
$('#i-sb-auth-submit-button').click( function(e) {
  e.preventDefault();

  // поля получаю для выделения в случае ошибки
  let input_login = document.getElementById('i-sb-auth-form-input-login');
  let input_password = document.getElementById('i-sb-auth-form-input-password');

  // получаю значения
  let user_login = input_login.value;
  let user_password = input_password.value;

  // TODO валидация на фронте, включая валидацию повтора пароля (она будет ток на фронте)
  let error = false;

  if(! /^[-_а-яёa-z0-9]{3,64}$/iu.test(user_login)) {
    input_login.classList.add('sb-form-input-field-er'); error = true;}

  let password_hash = str_to_sha256(user_password);

  // если валидация на фронте пройдена, посылаем на сервер
  if(error === false) {
    $.ajax({
      type: 'post',
      url: 'user/login',
      data: {'login': user_login, 'pass': password_hash},
      dataType: 'script'
    });
  }
});



// добавление задачи
$('#task-submit-sendform-button').click( function(e) {
  e.preventDefault();
  //$('#task-submit-spinner').removeClass('d-none');
  $('#task-submit-sendform-button').prop( "disabled", true );



  // поля получаю для выделения в случае ошибки
  let input_file = document.getElementById('t-form-input-image');
  let input_mail = document.getElementById('t-form-input-mail');
  let input_text = document.getElementById('t-form-input-text');

  // получаю значения
  let task_mail = input_mail.value;
  let task_text = input_text.value;
  let task_file = input_file.files[0];

  // TODO валидация на фронте, включая валидацию повтора пароля (она будет ток на фронте)
  let error = false;

  if(! /^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,})){0,64}$/.test(task_mail)) {
    input_mail.classList.add('sb-form-input-field-er'); error = true;}

  if(task_text.length > 4096) {
    input_text.classList.add('sb-form-input-field-er'); error = true;}

  let fd = new FormData();

  fd.append( 'file', task_file );
  fd.append( 'mail', task_mail );
  fd.append( 'text', task_text );

  //выполняем скрипт
  if(error === false) {
    $.ajax({
      type: 'post',
      url: 'task/add',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'script'
    });
  }

});



// апдейт задачи
$('#task-submit-update-button').click( function(e) {
  e.preventDefault();
  //$('#task-submit-spinner').removeClass('d-none');
  $('#task-submit-update-button').prop( "disabled", true );


  // поля получаю для выделения в случае ошибки
  let input_id = document.getElementById('t-form-input-id');
  let input_file = document.getElementById('t-form-input-image');
  let input_mail = document.getElementById('t-form-input-mail');
  let input_text = document.getElementById('t-form-input-text');
  let input_status = document.getElementById('t-form-input-status');

  // получаю значения
  let task_id = input_id.value;
  let task_mail = input_mail.value;
  let task_text = input_text.value;
  let task_file = input_file.files[0];
  let task_status = input_status.checked ? '2' : '1';

  // TODO валидация на фронте, включая валидацию повтора пароля (она будет ток на фронте)
  let error = false;

  if(! /^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,})){0,64}$/.test(task_mail)) {
    input_mail.classList.add('sb-form-input-field-er'); error = true;}

  if(task_text.length > 4096) {
    input_text.classList.add('sb-form-input-field-er'); error = true;}

  let fd = new FormData();

  fd.append( 'taskid', task_id );
  fd.append( 'file', task_file );
  fd.append( 'mail', task_mail );
  fd.append( 'text', task_text );
  fd.append( 'status', task_status );

  //выполняем скрипт
  if(error === false) {
    $.ajax({
      type: 'post',
      url: 'task/update',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'script'
    });
  }

});



$('.sb-form-input-field').change( function(e) {
  e.target.classList.remove('sb-form-input-field-er');
  $('#task-submit-sendform-button').prop( "disabled", false );
  $('#task-submit-update-button').prop( "disabled", false );
});


// переключатели форм
$('#login-reg-toggle').click( function(e) {
  e.preventDefault();

  $('#auth-form').css('display',"none");
  $('#reg-form').css('display',"block");
});


$('#login-auth-toggle').click( function(e) {
  e.preventDefault();

  $('#reg-form').css('display',"none");
  $('#auth-form').css('display',"block");
});



// переключатель превью
$('#task-preview-toggle').click( function(e) {
  e.preventDefault();

  if( $('#task-preview-block').css('display') === "none" )
    $('#task-preview-block').css('display', "block");
  else
    $('#task-preview-block').css('display', "none");
});



// превью
$('#t-form-input-text').change( function(e) {
  $('#task-preview-text').text( $('#t-form-input-text').val() );
});


$('#t-form-input-mail').change( function(e) {
  $('#task-preview-mail').text( $('#t-form-input-mail').val() );
});


$('#t-form-input-status').change( function(e) {
  $('#task-preview-status').text( $('#t-form-input-status').is(':checked') ? 'Выполнена' : 'Выполняется' );
});



// превью картинки
function readURL(input) {
  $('#task-preview-img').removeClass('d-none' );
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#task-preview-img').attr('src', e.target.result);

    };

    reader.readAsDataURL(input.files[0]);
  }
  else $('#task-preview-img').addClass('d-none' );
}


function reset_preview() {
  let prev_txt = $('#task-preview-text');
  let prev_mail = $('#task-preview-mail');
  let prev_img = $('#task-preview-img');
  let prev_status = $('#task-preview-status');

  prev_txt.text( prev_txt.attr('default') );
  prev_mail.text( prev_mail.attr('default') );
  prev_status.text( prev_status.attr('default') );
  prev_img.attr('src', prev_img.attr('default'));

  if(prev_img.attr('default') === '')
    prev_img.addClass('d-none');

  $('#task-submit-sendform-button').prop( "disabled", false );
  $('#task-submit-update-button').prop( "disabled", false );
}


// сортировка
function sort_tasks() {
  //получаем данные
  let m_order=$('#task-sort-order').val();
  let m_tpp=$('#task-sort-tpp').val();
  let m_bw = 0;
  if( $('#task-sort-bw').is(':checked') ) m_bw=1;

  window.location.href = "?order="+m_order+"&bw="+m_bw+"&tpp="+m_tpp;
}