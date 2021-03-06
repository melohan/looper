<?php
/**
 * This document manages the display of headers for pages. Each layout can decide to customize the banner
 * and in this case it will have to inform if:
 * the css class, the text, if there is a link, the url, the text link etc..
 */
// default for home page
if (!isset($cssClass)) {
    $cssClass = "dashboard";
    $text = "<h1>Exercise <br> Looper</h1>";
// personalized case
} else if (isset($text)) {
    $text = htmlentities($text);
// no text case
} else {
    $text = "";
}

//If title use URL
if (!isset($textLink)) {
    $urlLink = "";
    $useLink = false;
    $textLink = "";
} else if (isset($textLink)) {
    $textLink = htmlentities($textLink);
}
?>

<!DOCTYPE html>

<html>

<head>
    <title>ExerciseLooper</title>

    <link rel="stylesheet" href="/css/styles.css">
    <!-- Looper css -->
    <link rel="stylesheet" href="/css/looper.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</head>

<body>

<header class="<?= $cssClass ?>">
    <section class="container">
        <a href="/"><img src="/img/logo.png"/></a>
        <span class='exercise-label'>
                <?= $text; ?>
            <?php if ($useLink) : ?>
                <a href="<?= $urlLink; ?>"><?= $textLink; ?></a>
            <?php endif; ?>
            </span>
    </section>
</header>

</br>
</br>
<div class="container dashboard">
    <?= $content ?>
</div>

</body>

</html>