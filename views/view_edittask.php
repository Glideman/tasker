<div class="" style="min-height:100%; padding-top:61px; padding-bottom: 45px;">
    <div class="d-flex mx-n3 justify-content-center">
        <div class="sb-auth-form-container my-2">

            <form enctype="multipart/form-data" class="sb-auth-form">
                <input type="text" class="d-none" id="t-form-input-id" value="<?= $data->taskid ?>" readonly>

                <div class="sb-element-group sb-element-group-t">
                    <label for="t-form-input-mail">Почтовый адрес для данной задачи</label>
                    <input type="email" class="form-control sb-form-input-field" id="t-form-input-mail" placeholder="Введите email" value="<?= $data->mail ?>">
                </div>
                <div class="sb-element-group">
                    <label for="t-form-input-text">Текст задачи</label>
                    <textarea class="form-control sb-form-input-field" id="t-form-input-text" rows="3"><?= $data->text ?></textarea>
                </div>
                <div class="row sb-element-group">
                    <label for="t-form-input-image">Картинка</label>
                    <input type="file" class="form-control-file" id="t-form-input-image" onchange="readURL(this);" accept=".jpg, .gif, .png">
                    <small id="image-help" class="sb-text-element text-muted">JPG/GIF/PNG, не более 320х240 пикселей. Изображения большего размера будут уменьшены.</small>
                    <span class="sb-text-element"><a href="task/deleteimg?taskid=<?= $data->taskid ?>">Удалить картинку?</a></span>
                    <small id="image-help" class="sb-text-element text-muted">P.S. Удалённую картинку уже нельзя будет вернуть. Только загружать новую.</small>
                </div>
                <div class="row sb-element-group">
                    <span class="sb-text-element"><a href="#" id="task-preview-toggle">Предпросмотр</a></span>
                </div>
                <div class="row sb-element-group">
                    <input class="mx-0 mb-3" type="checkbox" id="t-form-input-status" <?= $data->status == 2 ? 'checked' : ''; ?>>
                    <label class="form-check-label mx-3" for="t-form-input-status">Статус</label>
                    <span class="sb-text-element"><a href="task/delete?taskid=<?= $data->taskid ?>" id="task-preview-toggle" style="color:darkred">Удалить задачу</a></span>
                </div>
                <div class="row sb-element-group sb-element-group-b  justify-content-center">
                    <button type="submit" class="btn btn-sm mx-3 sb-form-input-button" id="task-submit-update-button">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="task-submit-spinner"></span>
                        <span class="sr-only">Отправка...</span>
                        Сохранить
                    </button>
                    <button type="reset" class="btn btn-sm mx-3 sb-form-input-button" onclick="reset_preview()">Сбросить</button>
                </div>
            </form>
        </div>
    </div>

    <div class="sb-block" id="task-preview-block" style="display: none">
        <div class="row m-0">
            <div class="p-0">
                <img id="task-preview-img" src="img/<?= $data->imgpath ?>" default="img/<?= $data->imgpath ?>" class="mr-3 float-left <?= $data->imgpath == '' ? 'd-none' : '' ?>" style="max-height: 240px; max-width: 320px; " alt="Загрузка...">
            </div>
            <div class="col p-0">
                <div class="row m-0">
                    <div class="col p-0"><strong># <?= $data->taskid ?></strong><br><small id="task-preview-status" default="<?= $data->status == 1 ? 'Выполняется' : 'Выполнена' ?>"><?= $data->status == 1 ? 'Выполняется' : 'Выполнена' ?></small></div>
                    <div class="col p-0"><strong><?= $data->name ?></strong><br><small id="task-preview-mail" default="<?= $data->mail ?>"><?= $data->mail ?></small></div>
                    <div class="w-100 border my-3"></div>
                    <p class="m-0" id="task-preview-text" default="<?= $data->text ?>"><?= $data->text ?></p>
                </div>
            </div>
        </div>
    </div>
</div>