<?php
$headerText = "<span class='exercise-label'>Exercise: <a href='/answer/result'>voila</a></span>";
$headerClass = "heading results";

$answers = $params['answers'];
const DOUBLE_FILLED = 50;
?>
<?php if (count($answers) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Take</th>
            <?php foreach ($answers as $answer): ?>
                <th><a href="/answer/question/1"><?= $answer->getQuestion()->getText(); ?></a></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $answer): ?>
            <tr>
                <td><a href="/answer/user/<?= $answer->getId(); ?>"><?= $answer->getUser()->getName(); ?>></a></td>
                <td class="answer">
                    <?php if (empty($answer->getAnswer())): ?>
                        <i class="fa fa-times empty"></i>
                    <?php elseif (strlen($answer->getAnswer()) > DOUBLE_FILLED): ?>
                        <i class="fa fa-check-double filled"></i>
                    <?php else: ?>
                        <i class="fa fa-check short"></i>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>