<?php
session_start();

// Массив с данными "базы данных"
$mockDatabase = array(
    $mockDatabase = array(
        array(
            "title" => "Яндекс",
            "alt_titles" => array("Yandex", "Yandex.ru", "Yndx", "Яndex", "яндекс", "ya.ru"),
            "url" => "https://ya.ru",
            "description" => "Яндекс — российская многофункциональная поисковая система и интернет-портал.",
            "verified" => true
        ),
        array(
            "title" => "ВКонтакте",
            "alt_titles" => array("ВКонтакте", "ВК", "вк", "vk.com", "вк.ком"),
            "url" => "https://vk.com",
            "description" => "ВКонтакте – универсальное средство для общения и поиска друзей и одноклассников, которым ежедневно пользуются десятки миллионов людей",
            "verified" => true
        ),
        array(
            "title" => "Gmail",
            "alt_titles" => array("gmail", "гугл", "гугл почта", "почта", "Почта","Гугл почта","Гугл","Google","Гугл","Gmail","mail.google.com"),
            "url" => "https://mail.google.com",
            "description" => "Gmail - электронная почта от Google",
            "verified" => true
        ),
        array(
            "title" => "Google",
            "alt_titles" => array("гугл", "Гугл","Google","google.com"),
            "url" => "https://google.com",
            "description" => "Google - самая популярная поисковая система в мире.",
            "verified" => true
        ),
        array(
            "title" => "Одноклассники",
            "alt_titles" => array("Одноклассники", "OK.ru", "ок", "ok.ru", "Odnoklassniki"),
            "url" => "https://ok.ru",
            "description" => "Одноклассники — социальная сеть для поиска одноклассников, коллег и друзей.",
            "verified" => true
        ),
        array(
            "title" => "Авито",
            "alt_titles" => array("Avito", "avito.ru", "авито", "Avito Russia"),
            "url" => "https://avito.ru",
            "description" => "Авито — российский сайт объявлений для покупки и продажи товаров и услуг.",
            "verified" => true
        ),
        array(
            "title" => "Mail.ru",
            "alt_titles" => array("Mail.ru", "mail.ru", "мейл", "мэйл.ру", "Mail Ru"),
            "url" => "https://mail.ru",
            "description" => "Mail.ru — почтовый сервис и интернет-портал с новостями, играми и социальными сетями.",
            "verified" => true
        ),
        array(
            "title" => "РБК",
            "alt_titles" => array("RBK", "rbc.ru", "рбк", "РБК новости"),
            "url" => "https://rbc.ru",
            "description" => "РБК — ведущий российский информационный портал с новостями о бизнесе, политике и экономике.",
            "verified" => true
        ),
        array(
            "title" => "Кинопоиск",
            "alt_titles" => array("Кинопоиск", "Kinopoisk", "КиноПоиск", "kino.poisk.ru"),
            "url" => "https://www.kinopoisk.ru",
            "description" => "Кинопоиск — крупнейший российский сервис для поиска информации о фильмах, сериалах и актерах.",
            "verified" => true
        ),
        array(
            "title" => "Чемпионат",
            "alt_titles" => array("championat.com", "Чемпионат", "Чемпионат ком", "Спорт чемпионат"),
            "url" => "https://www.championat.com",
            "description" => "Чемпионат — популярный российский портал спортивных новостей и статистики.",
            "verified" => true
        ),
        array(
            "title" => "Лабиринт",
            "alt_titles" => array("Labirint", "Labirint.ru", "Лабиринт", "Лабиринт книги"),
            "url" => "https://www.labirint.ru",
            "description" => "Лабиринт — интернет-магазин книг, учебников и канцелярии.",
            "verified" => true
        ),
        array(
            "title" => "Рамблер",
            "alt_titles" => array("Rambler", "rambler.ru", "рамблер", "рамблер новости"),
            "url" => "https://www.rambler.ru",
            "description" => "Рамблер — российский информационно-развлекательный портал с новостями и почтовым сервисом.",
            "verified" => true
        ),
        array(
            "title" => "Хабр",
            "alt_titles" => array("Habr", "habr.com", "хабр", "Habrahabr"),
            "url" => "https://habr.com",
            "description" => "Хабр — сообщество разработчиков и специалистов в сфере ИТ и цифровых технологий.",
            "verified" => true
        ),
        array(
            "title" => "Циан",
            "alt_titles" => array("Cian", "cian.ru", "циан", "Циан недвижимость"),
            "url" => "https://www.cian.ru",
            "description" => "Циан — российская платформа для аренды и продажи недвижимости.",
            "verified" => true
        ),
        array(
            "title" => "Туту.ру",
            "alt_titles" => array("Tutu", "tutu.ru", "туту", "билеты туту"),
            "url" => "https://www.tutu.ru",
            "description" => "Туту.ру — сервис для поиска и покупки билетов на поезд, самолет и автобус.",
            "verified" => true
        ),
        array(
            "title" => "Газета.ру",
            "alt_titles" => array("Газета", "gazeta.ru", "газета ру", "Газета новости"),
            "url" => "https://www.gazeta.ru",
            "description" => "Газета.ру — один из ведущих российских новостных порталов.",
            "verified" => true
        ),
        array(
            "title" => "Озон",
            "alt_titles" => array("Ozon", "ozon.ru", "озон", "OZON.RU"),
            "url" => "https://www.ozon.ru",
            "description" => "Озон — крупный российский интернет-магазин товаров широкого ассортимента.",
            "verified" => true
        ),
        array(
            "title" => "РИА Новости",
            "alt_titles" => array("РИА", "ria.ru", "РИА Новости", "Риа"),
            "url" => "https://ria.ru",
            "description" => "РИА Новости — государственное информационное агентство с последними новостями России и мира.",
            "verified" => true
        ),
    )
    );

// Проверка на наличие поискового запроса
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : "";

// Обрабатываем историю поиска
if ($query) {
    if (!isset($_SESSION['search_history'])) {
        $_SESSION['search_history'] = array();
    }
    array_unshift($_SESSION['search_history'], $query);
    $_SESSION['search_history'] = array_slice($_SESSION['search_history'], 0, 5);
}

// Функция для поиска по "базе данных"
function searchResults($query, $database) {
    $results = array();
    foreach ($database as $item) {
        if (stripos($item['title'], $query) !== false || 
            stripos($item['description'], $query) !== false ||
            (isset($item['alt_titles']) && array_filter($item['alt_titles'], function($alt) use ($query) {
                return stripos($alt, $query) !== false;
            }))) {
            $results[] = $item;
        }
    }
    return $results;
}

// Функция для поиска в Википедии
function wikipediaSearch($query) {
    $url = "https://ru.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&utf8=&format=json";

    // Инициализация cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключаем проверку SSL-сертификата (не рекомендуется для боевого сервера)
    
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);

        if (!empty($data['query']['search'])) {
            $result = $data['query']['search'][0];
            $title = $result['title'];
            $snippet = strip_tags($result['snippet']);
            $pageUrl = "https://ru.wikipedia.org/wiki/" . urlencode($title);

            return array(
                "title" => $title,
                "snippet" => $snippet,
                "url" => $pageUrl
            );
        }
    }
    return null;
}


// Получаем результаты поиска по "базе данных"
$results = searchResults($query, $mockDatabase);

// Получаем результат поиска в Википедии
$wikiResult = $query ? wikipediaSearch($query) : null;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты поиска для "<?php echo $query; ?>"</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    
    <div class="search">
        <form action="search.php" method="GET">
            <img src="/img/favicon.png" alt="Логотип" width="40" height="40"/>
            <h1>qsearch</h1>
                <input type="text" name="query" placeholder="Ваш запрос" required class="search-input">
                <button type="submit" class="search-icon">
                </button>
        </form>
    </div>
    <style>
        /* Стили для страницы */
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #1e1e1e;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        .result-item {
            background-color: #2b2b2b;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background-color: #2b2b2b;
            margin: 15px left; /* Центрируем контейнер */
            max-width: 800px; /* Ограничиваем ширину */
            border: 6px solid rgba(255, 255, 255, 0.08);
        }
        .favicon {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        .result-content {
            flex: 1;
        }
        .result-title {
            font-size: 20px;
            font-weight: bold;
            color: #9e9eff;
        }
        .result-title a {
            color: #9e9eff;
            text-decoration: none;
        }
        .result-title a:hover {
            text-decoration: underline;
        }
        .verified {
            font-size: 16px;
            color: #2b6de5;
            margin-left: 5px;
        }
        .result-url {
            color: #aaaaaa;
            font-size: 14px;
            margin: 5px 0;
        }
        .result-description {
            color: #cfcfcf;
            font-size: 15px;
            margin-top: 5px;
        }
        .extra-links {
            margin-top: 10px;
            font-size: 14px;
            color: #9e9eff;
        }
        .extra-links a {
            color: #9e9eff;
            text-decoration: none;
            margin-right: 10px;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }

        .wiki-result {
            background-color: #2d2d2d;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        .wiki-title a {
            font-size: 20px;
            color: #9e9eff;
            font-weight: bold;
            text-decoration: none;
        }
        .wiki-title a:hover {
            text-decoration: underline;
        }
        .wiki-snippet {
            color: #cfcfcf;
            font-size: 15px;
            margin-top: 5px;
        }
   /* Стили контейнера поиска */
   .search {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #2b2b2b;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 1000;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo {
        margin-right: 10px;
    }

    .title {
        margin: 0;
        font-size: 24px;
        color: #ffffff;
    }

    .input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    /* Поле ввода */
    .search-input {
        width: 300px;
        padding: 10px 40px 10px 15px; /* Оставляем место для иконки справа */
        font-size: 18px;
        border-radius: 35px;
        border: 1px solid #cccccc;
        outline: none;
        font-family: "Montserrat", sans-serif;
        box-sizing: border-box;
    }

    /* Кнопка иконки поиска */
    .search-icon {
        position: absolute;
        right: 10px; /* Позиция иконки справа */
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
    }

    .icon-image {
        width: 100%;
        height: 100%;
    }
    </style>
</head>
<body>
    <h1>Результаты поиска для "<?php echo $query; ?>"</h1>

    <?php if (!empty($results)): ?>
        <?php foreach ($results as $result): ?>
            <?php
            $parsedUrl = parse_url($result['url']);
            $faviconUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/favicon.ico';
            ?>
            <div class="result-item">
                <img src="<?php echo $faviconUrl; ?>" alt="Favicon" class="favicon" onerror="this.style.display='none'">
                <div class="result-content">
                    <div class="result-title">
                        <a href="<?php echo $result['url']; ?>" target="_blank"><?php echo $result['title']; ?></a>
                        <?php if (isset($result['verified']) && $result['verified']): ?>
                            <span class="verified">✔️</span>
                        <?php endif; ?>
                    </div>
                    <div class="result-url"><?php echo $parsedUrl['host']; ?></div>
                    <div class="result-description"><?php echo $result['description']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Ничего не найдено по вашему запросу.</p>
        <p>qsearch на ранней стадии разработки, поэтому в нём есть далеко не вся информация!.</p>
    <?php endif; ?>

    <!-- Результат поиска по Википедии -->
    <?php if ($wikiResult): ?>
     <div class="result-item">
                <img src="https://www.wikipedia.org/static/favicon/wikipedia.ico" alt="Favicon" class="favicon" onerror="this.style.display='none'">
                <div class="result-content">
                    <div class="result-title"> 
           <div class="wiki-title"><a href="<?php echo $wikiResult['url']; ?>" target="_blank"><?php echo $wikiResult['title']; ?></a></div>
           <div class="wiki-snippet"><?php echo $wikiResult['snippet']; ?></div>
                    </div>
                </div>
            </div>
    <?php endif; ?>

</body>
</html>

