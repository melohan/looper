<?php
$headerText = '<span class="exercise-label">voila</span>';
$headerClass = "heading answering";
?>
    <h1>Your take</h1>
    <p>If you'd like to come back later to finish, simply submit it with blanks</p>

    <form action="/exercise/fulfillments" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden"
                                                                                           value="&#x2713;"/><input
                type="hidden" name="authenticity_token"
                value="SKgOEkmC0lE3Qz3q+RHf0YOhlIhkJ/DX6m8TcOEG/Wn4UGF3gD0upgrsWUeXa0PY+8+o3cueaY1PjHu2xB/srQ=="/>


        <input type="hidden" value="490" name="fulfillment[answers_attributes][][field_id]"
               id="fulfillment_answers_attributes__field_id"/>
        <div class="field">
            <label for="fulfillment_answers_attributes__value">la réponse d</label>
            <input type="text" name="fulfillment[answers_attributes][][value]"
                   id="fulfillment_answers_attributes__value"/>

        </div>

        <div class="actions">
            <a class="button" href="#">Save</a>
            <!-- <input type="submit" name="commit" value="Save" data-disable-with="Save" /> -->
        </div>
    </form>