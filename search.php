<?php
session_start();

// Настройки подключения к MySQL
$host = 'localhost';
$dbname = '';
$username = '';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . htmlspecialchars($e->getMessage()));
}

$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : "";
$mathResult = null;

// Функция для вычисления математических выражений безопасно
function evaluateMathExpression($expression) {
    $allowedChars = '/^[0-9\+\-\*\/\.\s()]+$/';
    if (preg_match($allowedChars, $expression)) {
        try {
            $result = eval('return ' . $expression . ';');
            return $result !== false ? $result : "Ошибка при вычислении";
        } catch (Throwable $e) {
            return "Некорректное выражение";
        }
    }
    return "Некорректный ввод";
}

// Пример с mathResult
if ($query && preg_match('/^[0-9\+\-\*\/\.\s()]+$/', $query)) {
    $mathResult = evaluateMathExpression($query);
}

// Функция поиска по базе
function searchResults($query, $pdo) {
    $results = [];
    $keywords = array_map('trim', explode(' ', $query));
    $sql = "SELECT * FROM websites WHERE ";
    $conditions = [];
    $params = [];

    if (preg_match('/\.(html|php)$/', $query)) {
        $conditions[] = "url LIKE :query";
        $params[':query'] = '%' . $query . '%';
    } else {
        foreach ($keywords as $index => $keyword) {
            $conditions[] = "(title LIKE :keyword{$index} OR description LIKE :keyword{$index} OR alt_titles LIKE :keyword{$index})";
            $params[":keyword{$index}"] = '%' . $keyword . '%';
        }
    }

    $sql .= implode(' OR ', $conditions);
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

// Функция поиска Википедии (оптимизирована для минимизации ошибок)
function wikipediaSearch($query) {
    $url = "https://ru.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&utf8=&format=json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data['query']['search'])) {
            $result = $data['query']['search'][0];
            return [
                "title" => $result['title'],
                "snippet" => strip_tags($result['snippet']),
                "url" => "https://ru.wikipedia.org/wiki/" . urlencode($result['title'])
            ];
        }
    }
    return null;
}

// Запросы и результаты
$results = searchResults($query, $pdo);
$wikiResult = $query ? wikipediaSearch($query) : null;
?>






<!DOCTYPE html>

<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Результаты поиска для "<?php echo $query; ?>"</title>

    <link rel="icon" type="image/png" href="/img/favicon.png">



    <!-- CSS стили -->

    <style>


            .search-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            outline: none;
            box-sizing: border-box;
        }

        /* Ensure icon is small and aligned */
        .search-icon img {
            width: 20px;
            height: 20px;
            display: block;
            filter: brightness(0) invert(1);
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer;
            filter: brightness(0) invert(1);
        }
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


    </style>

</head>

<body>

    <h1>Результаты поиска для "<?php echo $query; ?>"</h1>



    <?php if ($mathResult !== null): ?>

        <h2>Результат вычисления: <?php echo $mathResult; ?></h2>

    <?php endif; ?>



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

        <p>qsearch на ранней стадии разработки, поэтому в нём есть далеко не вся информация!. Напишите @qwnbe_m в Telegram, если хотите добавить свой сайт на qsearch</p>

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


</body>

</html>
