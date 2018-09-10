<!DOCTYPE html>
<head>
    <title>Публикатор</title>
    <meta charset="utf-8">

    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no">

    <meta name="theme-color" content="#607D8B">

    <script src="../style/material/material.min.js"></script>
    <script src="../app/jquery-1.12.0.min.js"></script>
    <link   href="../style/material/material.css" rel="stylesheet" >
    <link   href="../style/css/view.css" rel="stylesheet">
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <a href="/"><span class="mdl-layout-title">Публикатор</span></a>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="/proxy">Прокси</a>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Публикатор</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="/exit">Выход</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <?php include HOME_DIR.'/application/views/'.$content_view; ?>
        </div>
    </main>
</div>
</body>

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

<div aria-live="assertive" aria-atomic="true" aria-relevant="text" class="mdl-snackbar mdl-js-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button type="button" class="mdl-snackbar__action"></button>
</div>

