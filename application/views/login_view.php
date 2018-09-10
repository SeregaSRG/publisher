<!-- Login -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center" style="width: 334px">
    <form method="post" action="login/process">
        <div class="mdl-card__title">
            <h1 class="mdl-card__title-text">Вход по логину</h1>
            <?php if (Parameters::Get('error') == -3): ?>
                <p style="color: red">Заполните все поля!</p>
            <?php endif; ?>
            <?php if (Parameters::Get('error') == -2): ?>
                <p style="color: red">Логин или пароль неверные</p>
            <?php endif; ?>
            <?php if (Parameters::Get('error') == -1): ?>
                <p style="color: red">Ошибка базы данных</p>
            <?php endif; ?>
        </div>
        <div class="mdl-card__supporting-text">
            <div id="classic_login">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label for="login" class="mdl-textfield__label">Логин</label>
                    <input type="text" class="mdl-textfield__input" id="login" name="login" value="<?php echo Parameters::Get('login')?>" required/>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label for="log_password" class="mdl-textfield__label">Пароль</label>
                    <input type="password" class="mdl-textfield__input" id="password" name="password" required/>
                </div>
            </div>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored no-select" value="Войти" style="margin: 4px">
        </div>
    </form>
</div>
<!-- !Login -->