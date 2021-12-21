<?php
$cssClass = "heading results";
$text = "Exercise: ";
$useLink = $params['exercise'] != null;
$textLink = $params['exercise'] != null ? $params['exercise']->getTitle() : '';
$urlLink = $params['exercise'] != null ? '/answer/exercise/' . $params['exercise']->getId() : '';


$exercise = $params['exercise'];
$questions = $params['questions'];
const DOUBLE_FILLED = 50;
$users = $params['users'];
?>
<?php if (isset($questions) && !empty($questions)): ?>
    <table>
        <thead>
        <tr>
            <th>Take</th>
            <?php foreach ($questions as $question): ?>
                <th>
                    <a href="/answer/question/<?= $question->getId(); ?>"><?= htmlspecialchars($question->getText()); ?></a>
                </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php if (!is_null($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <a href="/answer/user/<?= $user->getId(); ?>/exercise/<?= $exercise->getId(); ?>"><?= $user->getName(); ?></a>
                    </td>

                    <?php
                    $answers = \App\Models\Answer::getAnswersByExercise($exercise->getId(), ['user_id' => $user->getId()]);
                    ?>

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
        <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
