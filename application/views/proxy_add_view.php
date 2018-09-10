<!-- Login -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center">
    <form  method="post" action="add_process">
        <div class="mdl-card__title">
            <h1 class="mdl-card__title-text">Добавление PROXY</h1>
        </div>
        <div class="mdl-card__supporting-text">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="ip" class="mdl-textfield__label">IP:port</label>
                <input type="text" class="mdl-textfield__input" id="ip" name="ip" required/>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="login" class="mdl-textfield__label">Логин</label>
                <input type="text" class="mdl-textfield__input" id="login" name="login" required>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="password" class="mdl-textfield__label">Пароль</label>
                <input type="text" class="mdl-textfield__input" id="password" name="password" required/>
            </div>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored no-select" value="Добавить" style="margin: 4px">
        </div>
    </form>
</div>
<!-- !Login -->