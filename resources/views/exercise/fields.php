<?php
$headerText = !empty($params['getExercise']['title']) ? 'Exercise : '.$params['getExercise']['title'] : 'New exercise' ;
$headerClass = "heading managing";
?>
<div class="row">
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
                <?php  if (!empty($params['getQuestion'])) : foreach ($params['getQuestion'] as $key => $value) :  ?>
                   
                <tr>
                    <td><?= $value['text'] ?></td>
                    <td>
                        <a title="Edit" href="/question/edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>

        <a data-confirm="Are you sure? You won&#39;t be able to further edit this exercise" class="button" rel="nofollow" data-method="put" href="/"><i class="fa fa-comment"></i>
            Complete and be ready for answers</a>

    </section>
    <section class="column">
        <h1>New Field</h1>
        <form action="/exercise/fields" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="h7qdtoWh6/AXCQQfdaupw16QwDJ3SJyW0wQvI7Z6D10LM/l3xR0ke0ZFn8Nes0+LR7onELPPR0XAs7z5kX4M8Q==" />

            <div class="field">
                <label for="field_label">Label</label>
                <input type="text" name="field[label]" id="field_label" />
            </div>

            <div class="field">
                <label for="field_value_kind">Value kind</label>
                <select name="field[value_kind]" id="field_value_kind">
                    
                    <?php  if (!empty($params['getType'])) : foreach ($params['getType'] as $key => $value) :  ?>
                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>

            <div class="actions">
                <a class="button" href="#">Create field</a>
                <!--<input type="submit" name="commit" value="Create Field" data-disable-with="Create Field" />-->
            </div>
        </form>
    </section>
</div>