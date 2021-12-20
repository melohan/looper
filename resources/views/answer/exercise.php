<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'><a href='/answer/exercise/" . $exercise->getId() . "'>" . htmlspecialchars($exercise->getTitle()) . "</a></span>" : "";
$questions = $params['questions'];
$headerClass = "heading results";
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
        </tbody>
    </table>
<?php endif; ?>
