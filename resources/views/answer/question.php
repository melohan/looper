<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'><a href='/answer/exercise/" . $exercise->getId() . "'>" . $exercise->getTitle() . "</a></span>" : "";
$headerClass = "heading results";
$answers = $params['answers'];
?>
<?php if (is_array($answers) && count($answers) > 0): ?>
    <h1><?= $answers[0]->getQuestion()->getText(); ?></h1>

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
                <td><a href="/answer/user/<?= $answer->getUser()->getId(); ?>/exercise/<?= $exercise->getId(); ?>"><?= $answer->getUser()->getName(); ?></a>
                </td>
                <td><?= $answer->getAnswer(); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>