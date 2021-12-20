<?php

$cssClass = "heading results";
$text = "Exercise: ";
$useLink = $params['exercise'] != null;
$textLink = $params['exercise'] != null ? $params['exercise']->getTitle() : '';
$urlLink = $params['exercise'] != null ? '/answer/exercise/' . $params['exercise']->getId() : '';

$exercise = $params['exercise'];
$answers = $params['answers'];
?>
<?php if (isset($answers) && !empty($answers)): ?>
    <h1><?= $answers[0]->getUser()->getName(); ?></h1>

    <?php foreach ($answers as $answer): ?>
        <dl class="answer">
            <dt><?= htmlspecialchars($answer->getQuestion()->getText()); ?></dt>
            <dd><?= htmlspecialchars($answer->getAnswer()); ?></dd>
        </dl>
    <?php endforeach; ?>
<?php endif; ?>
