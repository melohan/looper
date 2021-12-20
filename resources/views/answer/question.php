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
    <h1><?= htmlspecialchars($answers[0]->getQuestion()->getText()); ?></h1>

    <table>
        <thead>
        <tr>
            <th>Take</th>
            <th>Content</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $answer): ?>
            <tr>
                <td>
                    <a href="/answer/user/<?= $answer->getUser()->getId(); ?>/exercise/<?= $exercise->getId(); ?>"><?= $answer->getUser()->getName(); ?></a>
                </td>
                <td><?= htmlspecialchars($answer->getAnswer()); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>