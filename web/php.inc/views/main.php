<!DOCTYPE html>
<html lang="ru">
    <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?= $summary->now_temp ?> <?= $language->location->address; ?>" />
        <meta property="og:description" content="<?= $language->description; ?>" />
        <meta property="og:url" content="http://miksrv.ru/meteo" />
        <meta property="og:site_name" content="<?= $language->title; ?>" />
        <meta property="og:image" content="http://miksrv.ru/meteo/images/background/<?= $summary->background; ?>" />
        <meta property="og:updated_time" content="<?= date('c', strtotime($summary->time_update)); ?>" />
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
        <section id="main">
            <div id="background-overlay">
                <div class="background" style="background-image: url(images/background/<?= $summary->background; ?>);"></div>
            </div>
            <div class="wrapper content">
                <div class="info">
                    <h1><?= $language->location->address; ?></h1>
                    <h4><?= $language->location->country; ?></h4>
                    <div class="weather-now">
                        <div class="weather-current">
                            <?php if (date('H') >= 7 && date('H') <= 20): ?><i class="wi wi-day-sunny"></i>
                            <?php else: ?><i class="wi <?= $summary->moon_phase ?>"></i>
                            <?php endif; ?>
                            <?php if ($summary->now_temp): echo $summary->now_temp ?><i class="wi wi-celsius"></i>
                            <?php else: ?><i class="wi wi-na"></i>
                            <?php endif; ?>
                        </div>
                        <div class="weather-range">
                            <div class="range-max">
                                <?php if ($summary->max_temp): echo $summary->max_temp ?><i class="wi wi-celsius"></i>
                                <?php else: ?><i class="wi wi-na"></i>
                                <?php endif; ?>
                            </div>
                            <div class="range-min">
                                <?php if ($summary->min_temp): echo $summary->min_temp ?><i class="wi wi-celsius"></i>
                                <?php else: ?><i class="wi wi-na"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="https://ru.wikipedia.org/wiki/%D0%92%D0%B5%D1%82%D1%80%D0%BE-%D1%85%D0%BE%D0%BB%D0%BE%D0%B4%D0%BE%D0%B2%D0%BE%D0%B9_%D0%B8%D0%BD%D0%B4%D0%B5%D0%BA%D1%81" target="_blank" rel="nofollow" class="label" style="<?= $summary->wct_style ?>">
                            WCT: <?= $language->wct[$summary->wct_index] ?> *
                        </a>
                    </div>
                    <div class="hint">
                        <?= $language->last_update ?>: 
                        <?php if ($summary->time_update): echo $summary->time_update  ?> (<?= $summary->time_elapsed; ?>)
                        <?php else: ?><i class="wi wi-na"></i>
                        <?php endif; ?>
                    </div>
                    <div class="hint">
                        <?= $language->forecast_weather ?>: <?= $language->forecast[$summary->forecast] ?>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="wrapper content">
                <div class="row">
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/temp1.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/temp2.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/humd.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/press.inc.php'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/light.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/wind.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/sunrise.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/sunset.inc.php'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/dewpoint.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/battery.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/moonrise.inc.php'; ?>
                    </div>
                    <div class="collumn">
                        <?php include_once VIEWPATH . 'sections/moonset.inc.php'; ?>
                    </div>
                </div>
                <div class="small">
                    * Ветро-холодовой индекс, опасность для здоровья согласно «индексу охлаждения» (канадская шкала)
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
</html>