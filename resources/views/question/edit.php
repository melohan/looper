<?php

$headerText = "test";
$headerClass = "heading managing";

$question = $params['question'];
$types = $params['types'];
?>

    <h1>Editing Field</h1>

<?php if (isset($question) && !empty($question)): ?>
    <form action="/question/update/<?= $question->getId(); ?>" accept-charset="UTF-8" method="post"><input name="utf8"
                                                                                                           type="hidden"
                                                                                                           value="&#x2713;"/>

        <input type="hidden" name="_method" value="patch"/>

        <div class="field">
            <label for="field_label">Label</label>
            <input type="text" value="<?= htmlspecialchars($question->getText()); ?>" name="field[label]"
                   id="field_label"/>
        </div>

        <div class="field">
            <label for="field_value_kind">Value kind</label>
            <select name="typeId" id="field_value_kind">
                <option value="<?= $question->getType()->getId(); ?>" selected disabled
                        hidden><?= $question->getType()->getName(); ?></option>
                <?php if (!empty($types)) : foreach ($types as $key => $type) : ?>
                    <option value="<?= $type->getId(); ?>"><?= $type->getName(); ?></option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>

        <div class="actions">
            <input type="submit" name="commit" value="Update Field" data-disable-with="Update Field"/>
        </div>
    </form>
<?php endif; ?>