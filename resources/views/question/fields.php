<?php

$exercise = $params['exercise'];
$types = $params['types'];

$headerClass = "heading managing";
$headerText =
    (!is_null($exercise) && $exercise->getTitle()
        != null) ? "Exercise: <span class='exercise-label'>
<a href='/question/fields/" . $exercise->getId() . "'>" . htmlspecialchars($exercise->getTitle()) . "</a></span>" : "New exercise";

?>
<div class="row">
    <?php if (isset($exercise) && !empty($exercise)) : ?>
        <section class="column">
            <h1>Fields</h1>
            <table class="records">
                <thead>
                <tr>
                    <th>Label</th>
                    <th>Value kind</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($exercise->getQuestions())) : foreach ($exercise->getQuestions() as $key => $question) : ?>

                    <tr>
                        <td><?= htmlspecialchars($question->getText()); ?></td>
                        <td><?= htmlspecialchars($question->getType()->getName()); ?></td>
                        <td>
                            <a title="Edit" href="/question/edit/<?= $question->getId(); ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete"
                               data-href="/question/delete/" data-val="<?= $question->getId(); ?>"><i
                                        class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
                endif; ?>
                </tbody>
            </table>

            <a data-confirm="Are you sure? You won&#39;t be able to further edit this exercise" class="button"
               rel="nofollow" data-method="put" data-href="/exercise/update" data-val="<?= $exercise->getid() ?>"
               data-status="2"><i class="fa fa-comment"></i>
                Complete and be ready for answers</a>

        </section>
        <section class="column">
            <h1>New Field</h1>
            <form action="/question/create" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden"
                                                                                        value="&#x2713;"/><input
                        type="hidden" name="authenticity_token"
                        value="h7qdtoWh6/AXCQQfdaupw16QwDJ3SJyW0wQvI7Z6D10LM/l3xR0ke0ZFn8Nes0+LR7onELPPR0XAs7z5kX4M8Q=="/>

                <div class="field">
                    <label for="field_label">Label</label>
                    <input type="text" name="name" id="field_label"/>
                    <input type="hidden" name="exerciseId" value="<?= $exercise->getId(); ?>"/>
                </div>

                <div class="field">
                    <label for="field_value_kind">Value kind</label>
                    <select name="typeId" id="field_value_kind">

                        <?php if (!empty($types)) : foreach ($types as $key => $type) : ?>
                            <option value="<?= $type->getId(); ?>"><?= $type->getName(); ?></option>
                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>

                <div class="actions">
                    <input type="submit" name="commit" value="Create Field" data-disable-with="Create Field"/>
                </div>
            </form>
        </section>
    <?php endif; ?>
</div>