<div class="d-flex justify-content-center align-items-center mx-n3" style="min-height:100%; padding-top:61px; padding-bottom: 45px;">
    <div class="sb-auth-form-container">
        <form id="auth-form" class="sb-auth-form" style="display:block">
            <div class="sb-element-group sb-element-group-t">
                <input type="text" class="form-control sb-form-input-field" id="i-sb-auth-form-input-login" placeholder="Пользователь*">
                <input type="password" class="form-control sb-form-input-field" id="i-sb-auth-form-input-password" placeholder="Пароль*">
            </div>
            <div class="row sb-element-group justify-content-center">
                <button type="submit" class="btn btn-sm mx-3 sb-form-input-button" id="i-sb-auth-submit-button">Войти</button>
                <button type="reset" class="btn btn-sm mx-3 sb-form-input-button">Сброс</button>
            </div>
            <div class="row sb-element-group sb-element-group-b justify-content-center">
                <span class="sb-text-element">Нет аккаунта? <a href="#" id="login-reg-toggle">Зарегистрироваться</a></span>
            </div>
        </form>

        <form id="reg-form" class="sb-auth-form" style="display:none">
            <div class="sb-element-group sb-element-group-t">
                <input type="text" class="form-control sb-form-input-field" id="i-sb-reg-form-input-login" placeholder="Логин*">
                <input type="password" class="form-control sb-form-input-field" id="i-sb-reg-form-input-password" placeholder="Пароль*">
                <input type="password" class="form-control sb-form-input-field" id="i-sb-reg-form-input-passconf" placeholder="Повторите пароль*">
            </div>
            <div class="sb-element-group">
                <input type="text" class="form-control sb-form-input-field" id="i-sb-reg-form-input-name" placeholder="Имя">
                <input type="text" class="form-control sb-form-input-field" id="i-sb-reg-form-input-mail" placeholder="Почта">
            </div>
            <div class="row sb-element-group justify-content-center">
                <button type="submit" class="btn btn-sm mx-3 sb-form-input-button" id="i-sb-reg-submit-button">Регистрация</button>
                <button type="reset" class="btn btn-sm mx-3 sb-form-input-button">Сброс</button>
            </div>
            <div class="row sb-element-group sb-element-group-b justify-content-center">
                <span class="sb-text-element">Уже зарегистрированы? <a href="#" id="login-auth-toggle">Войти</a></span>
            </div>
        </form>
    </div>
</div>