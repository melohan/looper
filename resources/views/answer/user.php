<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'><a href='/answer/exercise/" . $exercise->getId() . "'>" . htmlspecialchars($exercise->getTitle()) . "</a></span>" : "";
$headerClass = "heading results";
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
