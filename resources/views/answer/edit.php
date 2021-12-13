<?php
$exercise = $params['exercise'];
$headerText = ($exercise != null) ? "<span class='exercise-label'>" . $exercise->getTitle() . "</span>" : "";
$answers = $params['answers'];
$headerClass = "heading answering";
?>
<?php if (is_array($answers) && count($answers) > 0): ?>
    <h1>Your take</h1>
    <p>Bookmark this page, it's yours. You'll be able to come back later to finish.</p>

    <form action="/answer/fulfillments/<?= $exercise->getId(); ?>" accept-charset="UTF-8" method="post">

        <div class="field">
            <?php foreach ($answers as $answer): ?>
                <label for="fulfillment_answers_attributes__value"><?= $answer->getQuestion()->getText(); ?></label>
                <input type="hidden" value="<?= $answer->getQuestion()->getId(); ?>"
                       name="fulfillment[answers_attributes][][questionId]"
                />
                <?php if ($answer->getQuestion()->getType()->getId() == \App\models\QuestionType::SINGLE): ?>
                    <input type="text" value="<?= $answer->getAnswer(); ?>"
                           name="fulfillment[answers_attributes][][value]"
                    />
                <?php else: ?>
                    <textarea value="<?= $answer->getAnswer(); ?>" name="fulfillment[answers_attributes][][value]"
                    ></textarea>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="actions">
            <button type="submit" name="button" value="Save">Save</button>
        </div>
    </form>
<?php endif; ?>