<?php
$headerClass = "heading answering";
$exercises = $params['exercises'];
?>
<ul class="ansering-list">

    <?php if (isset($exercises) && !empty($exercises)): ?>

        <?php foreach ($exercises as $exercise) : ?>
            <li class="row">
                <div class="column card">
                    <div class="title"><?= htmlspecialchars($exercise->getTitle()); ?></div>
                    <a class="button" href="/exercise/fulfillments/<?= $exercise->getId(); ?>">Take it</a>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>