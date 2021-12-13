<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'>" . $exercise->getTitle() . "</span>" : "";
$questions = isset($params['exercise']) ? $exercise->getQuestions() : null;
$headerClass = "heading answering";
?>
<?php if (is_array($questions) && count($questions) > 0): ?>
    <h1>Your take</h1>
    <p>If you'd like to come back later to finish, simply submit it with blanks</p>

    <form action="/answer/fulfillments/<?= $exercise->getId(); ?>" accept-charset="UTF-8" method="post">

        <div class="field">
            <?php foreach ($exercise->getQuestions() as $question): ?>
                <label for="fulfillment_answers_attributes__value"><?= $question->getText(); ?></label>
                <input type="hidden" value="<?= $question->getId(); ?>"
                       name="fulfillment[answers][][questionId]"
                       id="fulfillment_answers_attributes__field_id" />
                <?php if ($question->getType()->getId() == \App\models\QuestionType::SINGLE): ?>
                    <input type="text" name="fulfillment[answers][][value]"
                           id="fulfillment_answers_attributes__value"/>
                <?php else: ?>
                    <textarea name="fulfillment[answers][][value]"
                              id="fulfillment_answers_attributes__value"></textarea>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="actions">
            <button type="submit" value="Save">Save</button>
        </div>
    </form>
<?php endif; ?>