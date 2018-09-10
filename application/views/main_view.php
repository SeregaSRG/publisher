<!-- Table -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center" style="max-width: 1024px; width: 100%">
    <div class="mdl-card__title">
        <h1 class="mdl-card__title-text center">Список задач</h1>
    </div>
    <div class="mdl-card__supporting-text">
        <a href="/add">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" style="float: right; margin: 15px 0 10px 0;">
                <i class="material-icons">add</i>
            </button>
        </a>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp center">
            <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">ID группы</th>
                <th class="mdl-data-table__cell--non-numeric">ID обсуждения</th>
                <th>Категория</th>
                <th>Токен</th>
                <th>Дата</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="forSearch">
            <?php
            foreach($data as $row)
            {
                echo "
                <tr>
                    <th class=\"mdl-data-table__cell--non-numeric clip\"><a href='http://vk.com/public".$row['group_id']."' target='_blank'>".$row['group_id']."</a></th>
                    <th class=\"mdl-data-table__cell--non-numeric clip\"><a href='http://vk.com/topic-".$row['group_id']."_".$row['topic_id']."' target='_blank'>".$row['topic_id']."</a></th>
                    <th>".$row['category']."</th>
                    <th>".substr($row['token'], 0, 9)."..</th>
                    <th>".$row['date']."</th>
                    <th>
                        <a href='/edit?id=".$row['id']."&group_id=".$row['group_id']."&topic_id=".$row['topic_id']."&category=".$row['category']."'>
                            <span class=\"mdl-chip\">
                                <span class=\"mdl-chip__text\">Редактировать</span>
                            </span>
                        </a>
                    </th>
                    <th>
                        <a href='/delete?id=".$row['id']."'>
                            <span class=\"mdl-chip\">
                                <span class=\"mdl-chip__text\">Удалить</span>
                            </span>
                        </a>
                    </th>
                </tr>
                ";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>