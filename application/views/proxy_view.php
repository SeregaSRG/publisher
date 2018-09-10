<!-- Table -->
<div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp center" style="max-width: 1024px; width: 100%">
    <div class="mdl-card__title">
        <h1 class="mdl-card__title-text center">Список PROXY</h1>
    </div>
    <div class="mdl-card__supporting-text">
        <a href="proxy/add">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" style="float: right; margin: 15px 0 10px 0;">
                <i class="material-icons">add</i>
            </button>
        </a>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp center">
            <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">IP</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="forSearch">
            <?php
            foreach($data as $row)
            {
                echo "
                <tr>
                    <th class=\"mdl-data-table__cell--non-numeric clip\">".$row['ip']."</th>
                    <th>".$row['login']."</th>
                    <th>".$row['password']."</th>
                    <th>".$row['date']."</th>
                    <th>
                        <a href='proxy/delete?id=".$row['id']."'>
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