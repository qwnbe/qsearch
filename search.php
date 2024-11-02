<?php
session_start();
// Загружаем данные из JSON файла
$mockDatabaseFile = 'websites.json';

if (file_exists($mockDatabaseFile)) {
    $mockDatabaseData = file_get_contents($mockDatabaseFile);
    $mockDatabase = json_decode($mockDatabaseData, true);
} else {
}

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
    <!-- CSS стили -->
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
