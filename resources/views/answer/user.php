<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'><a href='/answer/exercise/" . $exercise->getId() . "'>" . $exercise->getTitle() . "</a></span>" : "";
$headerClass = "heading results";
$answers = $params['answers'];
?>
<?php if (is_array($answers) && count($answers) > 0): ?>
    <h1><?= $answers[0]->getUser()->getName(); ?></h1>

    <?php foreach ($answers as $answer): ?>
        <dl class="answer">
            <dt><?= $answer->getQuestion()->getText(); ?></dt>
            <dd><?= $answer->getAnswer(); ?></dd>
        </dl>
    <?php endforeach; ?>
<?php endif; ?>
