<?php

use App\Models\Exercise;

$headerText = $params['exercise']->getTitle();
$headerClass = "heading managing";
?>

<h1>Editing Field</h1>

<form action="#" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="_method" value="patch" /><input type="hidden" name="authenticity_token" value="itAjxA/fhUV5WWkBhMX1yH1krT0/QAKbUD5CaEurPvR3FBaqwjbSMnoFzC7riQnEWjhGaNwfrc6LtWjr1gXQvg==" />

    <div class="field">
        <label for="field_label">Label</label>
        <input type="text" value="" name="field[label]" id="field_label" />
    </div>

    <div class="field">
        <label for="field_value_kind">Value kind</label>
        <select name="field[value_kind]" id="field_value_kind">
            <option selected="selected" value="single_line">Single line text</option>
            <option value="single_line_list">List of single lines</option>
            <option value="multi_line">Multi-line text</option>
        </select>
    </div>

    <div class="actions">
        <a class="button" href="/">Update field</a>
        <!-- <input type="submit" name="commit" value="Update Field" data-disable-with="Update Field" />-->
    </div>
</form>

</body>