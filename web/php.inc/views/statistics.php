<!DOCTYPE html>
<html lang="ru">
    <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?= DIR_ROOT ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= DIR_ROOT ?>css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?= DIR_ROOT ?>css/weather-icons.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= DIR_ROOT ?>images/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= DIR_ROOT ?>images/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= DIR_ROOT ?>images/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= DIR_ROOT ?>images/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= DIR_ROOT ?>images/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= DIR_ROOT ?>images/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= DIR_ROOT ?>images/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= DIR_ROOT ?>images/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= DIR_ROOT ?>images/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= DIR_ROOT ?>images/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= DIR_ROOT ?>images/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= DIR_ROOT ?>images/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= DIR_ROOT ?>images/icons/favicon-16x16.png">
        <link rel="manifest" href="<?= DIR_ROOT ?>images/icons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= DIR_ROOT ?>images/icons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <title><?= $language->title; ?></title>
    </head>
    <body>
        <header>
            <div class="wrapper content">
                <div class="logo">
                    <a href="<?= DIR_ROOT ?>" title="<?= $language->title; ?>">
                        <img src="<?= DIR_ROOT ?>images/logo.png" alt="<?= $language->description; ?>" /> <?= $language->description; ?>
                    </a>
                </div>
                <nav>
                    <ul>
                        <?= $lang_menu; ?>
                    </ul>
                </nav>
            </div>
        </header>
        <section>
            <div class="wrapper content">
                <h2><?= $language->graphics; ?></h2>
                <div><?= $language->period->title ?>: 
                    <a href="javascript:void(0)" data-role="period" class="active" data-period="day" title=""><?= $language->period->day ?></a>
                    <a href="javascript:void(0)" data-role="period" data-period="week" title=""><?= $language->period->week ?></a>
                    <a href="javascript:void(0)" data-role="period" data-period="month" title=""><?= $language->period->month ?></a>
                </div>
                <h5><?= $language->charts1; ?></h5>
                <a name="chart1"></a>
                <div id="container1">
                    <div class="loading"></div>
                </div>
                <br>
                <h5><?= $language->charts2; ?></h5>
                <a name="chart2"></a>
                <div id="container2">
                    <div class="loading"></div>
                </div>
                <br>
                <h5><?= $language->charts3; ?></h5>
                <a name="chart3"></a>
                <div id="container3">
                    <div class="loading"></div>
                </div>
            </div>
        </section>
        <footer>
            <div class="wrapper content">
                <div>Powered by Arduino & PHP\HTML - See on <a href="https://github.com/miksrv/explorer" title="" target="_blank">Github</a></div>
                <div>Copyright &copy; <a href="http://miksrv.ru" title="" target="_blank">Mishka</a> 2016, Version <i><?= VERSION ?></i></div>
            </div>
        </footer>
    </body>
    <script type="text/javascript" src="<?= DIR_ROOT ?>js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript">var dir_root = '<?= DIR_ROOT ?>';</script>
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="<?= DIR_ROOT ?>js/charts.js"></script>
</html>