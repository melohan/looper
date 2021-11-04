<?php
$headerClass = "heading answering";
?>
<ul class="ansering-list">

    <li class="row">
    </li>

    <?php foreach ($params['allExercises'] as $key) : ?>
        <li class="row">
            <div class="column card">
                <div class="title"><?= $key['title']; ?></div>
                <a class="button" href="/exercise/fulfillments/<?= $key['id'] ?>">Take it</a>
            </div>
        </li>
    <?php endforeach; ?>

</ul>