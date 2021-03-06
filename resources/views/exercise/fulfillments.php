<?php
$exercise = $params['exercise'];

$text = ($exercise != null) ? "Exercise: " . $exercise->getTitle() : "";
$cssClass = "heading answering";

$questions = isset($params['exercise']) ? $exercise->getQuestions() : null;
?>


<?php if (isset($questions) && !empty($questions)): ?>
    <h1>Your take</h1>
    <p>If you'd like to come back later to finish, simply submit it with blanks</p>

    <form action="/answer/fulfillments/<?= $exercise->getId(); ?>" accept-charset="UTF-8" method="post">

        <div class="field">
            <?php foreach ($exercise->getQuestions() as $question): ?>
                <label for="fulfillment_answers_attributes__value"><?= htmlspecialchars($question->getText()); ?></label>
                <input type="hidden" value="<?= $question->getId(); ?>"
                       name="fulfillment[answers_attributes][][questionId]"
                />
                <?php if ($question->getType()->getId() == \App\models\QuestionType::SINGLE): ?>
                    <input type="text" name="fulfillment[answers_attributes][][value]"
                    />
                <?php else: ?>
                    <textarea name="fulfillment[answers_attributes][][value]"
                    ></textarea>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="actions">
            <button type="submit" name="button" value="Save">Save</button>
        </div>
    </form>
<?php endif; ?>