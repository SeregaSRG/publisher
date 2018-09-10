<!-- Login -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center">
    <form  method="post" action="add/process">
        <div class="mdl-card__title">
            <h1 class="mdl-card__title-text">Добавление нового задания</h1>
        </div>
        <div class="mdl-card__supporting-text">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="group_id" class="mdl-textfield__label">ID группы</label>
                <input type="text" class="mdl-textfield__input" id="group_id" name="group_id" required/>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="topic_id" class="mdl-textfield__label">ID обсуждения</label>
                <input type="text" class="mdl-textfield__input" id="topic_id" name="topic_id" required/>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="category" class="mdl-textfield__label">Категория</label>
                <input type="text" class="mdl-textfield__input" id="category" name="category" required>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="token" class="mdl-textfield__label">Токен</label>
                <input type="text" class="mdl-textfield__input" id="token" name="token" required/>
            </div>
            <br>
            <a href="https://oauth.vk.com/authorize?client_id=<?php echo APPLICATION?>&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=wall,offline,photos,groups&response_type=token&v=5.78&state=work-all.ru'" target="_blank">
                <div class="mdl-button mdl-js-button mdl-button--raised">
                    Получить токен
                </div>
            </a>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored no-select" value="Добавить" style="margin: 4px">
        </div>
    </form>
</div>
<!-- !Login -->