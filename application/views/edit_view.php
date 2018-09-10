<!-- Login -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center">
    <form  method="post" action="edit/process">
        <div class="mdl-card__title">
            <h1 class="mdl-card__title-text">Редактирование задания</h1>
        </div>
        <div class="mdl-card__supporting-text">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="group_id" class="mdl-textfield__label">ID группы</label>
                <input type="text" class="mdl-textfield__input" id="group_id" name="group_id" value="<?php echo Parameters::Get('group_id')?>" required/>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="topic_id" class="mdl-textfield__label">ID обсуждения</label>
                <input type="text" class="mdl-textfield__input" id="topic_id" name="topic_id" value="<?php echo Parameters::Get('topic_id')?>" required/>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="category" class="mdl-textfield__label">Категория</label>
                <input type="text" class="mdl-textfield__input" id="category" name="category" value="<?php echo Parameters::Get('category')?>" required>
            </div>
            <input type="hidden" value="<?php echo Parameters::Get('id')?>" name="id">
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored no-select" value="Изменить" style="margin: 4px">
        </div>
    </form>
</div>
<!-- !Login -->