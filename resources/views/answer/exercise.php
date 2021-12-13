<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'><a href='/answer/exercise/" . $exercise->getId() . "'>" . $exercise->getTitle() . "</a></span>" : "";

$answers = $params['answers'];
$headerClass = "heading results";
const DOUBLE_FILLED = 50;
$lastId = '';
$users = \App\Models\User::getByExercise(2);
?>
<?php if (is_array($answers) && count($answers) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Take</th>
            <?php foreach ($answers as $answer): ?>
                <?php if ($lastId != $answer->getQuestion()->getId()): ?>
                    <th>
                        <a href="/answer/question/<?= $answer->getQuestion()->getId(); ?>"><?= $answer->getQuestion()->getText(); ?></a>
                    </th>
                <?php endif; ?>
                <?php $lastId = $answer->getQuestion()->getId(); ?>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <a href="/answer/user/<?= $user->getId(); ?>/exercise/<?= $exercise->getId(); ?>"><?= $answer->getUser()->getName(); ?></a>
                </td>
                <?php $answers = \App\Models\Answer::getAnswersByExercise($exercise->getId(), ['user_id' => $user->getId()]); ?>
                <?php foreach ($answers as $answer): ?>
                    <td class="answer">
                        <?php if (empty($answer->getAnswer())): ?>
                            <i class="fa fa-times empty"></i>
                        <?php elseif (strlen($answer->getAnswer()) > DOUBLE_FILLED): ?>
                            <i class="fa fa-check-double filled"></i>
                        <?php else: ?>
                            <i class="fa fa-check short"></i>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
