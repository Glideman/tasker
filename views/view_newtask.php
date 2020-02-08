<div class="" style="min-height:100%; padding-top:61px; padding-bottom: 45px;">
    <div class="d-flex mx-n3 justify-content-center">
        <div class="sb-auth-form-container my-2">

            <form enctype="multipart/form-data" class="sb-auth-form">
                <div class="sb-element-group sb-element-group-t">
                    <label for="t-form-input-mail">Почтовый адрес для данной задачи</label>
                    <input type="email" class="form-control sb-form-input-field" id="t-form-input-mail" placeholder="Введите email" value="<?= is_null(App::$user) ? '' : App::$user->mail ?>">
                </div>
                <div class="sb-element-group">
                    <label for="t-form-input-text">Текст задачи</label>
                    <textarea class="form-control sb-form-input-field" id="t-form-input-text" rows="3"></textarea>
                </div>
                <div class="row sb-element-group">
                    <label for="t-form-input-image">Картинка</label>
                    <input type="file" class="form-control-file" id="t-form-input-image" onchange="readURL(this);" accept=".jpg, .gif, .png">
                    <small id="image-help" class="sb-text-element text-muted">JPG/GIF/PNG, не более 320х240 пикселей. Изображения большего размера будут уменьшены.</small>
                    <span class="sb-text-element"><a href="#" id="task-preview-toggle">Предпросмотр</a></span>
                </div>
                <div class="row sb-element-group sb-element-group-b  justify-content-center">
                    <button type="submit" class="btn btn-sm mx-3 sb-form-input-button" id="task-submit-sendform-button">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="task-submit-spinner"></span>
                        <span class="sr-only">Отправка...</span>
                        Готово
                    </button>
                    <button type="reset" class="btn btn-sm mx-3 sb-form-input-button" onclick="reset_preview()">Сбросить</button>
                </div>
            </form>
        </div>
    </div>

    <div class="sb-block" id="task-preview-block" style="display: none">
        <div class="row m-0">
            <div class="p-0">
                <img id="task-preview-img" src="" default="" class="mr-3 float-left d-none" style="max-height: 240px; max-width: 320px; " alt="Загрузка...">
            </div>
            <div class="col p-0">
                <div class="row m-0">
                    <div class="col p-0"><strong># 000</strong><br><small>Выполняется</small></div>
                    <div class="col p-0"><strong><?= is_null(App::$user) ? 'Гость' : App::$user->name; ?></strong><br><small id="task-preview-mail" default="<?= is_null(App::$user) ? '' : App::$user->mail ?>"><?= is_null(App::$user) ? '' : App::$user->mail ?></small></div>
                    <div class="w-100 border my-3"></div>
                    <p class="m-0" id="task-preview-text" default=""></p>
                </div>
            </div>
        </div>
    </div>
</div>