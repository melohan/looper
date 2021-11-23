<?php
$headerText = "";
$headerClass = "heading results";
?>

<div class="row">
    <section class="column">
        <h1>Building</h1>
        <table class="records">
            <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($params['building'] as $exercise) : ?>
                    <tr>
                        <td><?= $exercise->getTitle(); ?></td>
                        <td>
                            <?php if ($exercise->hasQuestions()) : ?>
                                <a title="Be ready for answers" rel="nofollow" data-method="put" data-href="/exercise/update" data-val="<?= $exercise->getid() ?>" data-status="ANSWERING" data-confirm="Are you sure?"><i class="fa fa-comment"></i></a>
                            <?php endif; ?>
                            <a title="Manage fields" href="/question/fields/<?= $exercise->getId(); ?>"><i class=" fa fa-edit"></i></a>
                            <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete" data-href="/exercise/delete/" data-val="<?= $exercise->getid() ?>"> <i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="column">
        <h1>Answering</h1>
        <table class="records">
            <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($params['answering'] as $exercise) : ?>
                    <tr>
                        <td><?= $exercise->getTitle(); ?></td>
                        <td>
                            <a title="Show results" href="/answer/result/<?= $exercise->getId(); ?>"><i class="fa fa-chart-bar"></i></a>
                            <a title="Close" rel="nofollow" data-method="put" data-href="/exercise/update" data-val="<?= $exercise->getid() ?>" data-status="CLOSED" data-confirm="Are you sure?"><i class="fa fa-minus-circle"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="column">
        <h1>Closed</h1>
        <table class="records">
            <thead>
                <tr>
                    <th>Title</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($params['closed'] as $exercise) : ?>
                    <tr>
                        <td><?= $exercise->getTitle(); ?></td>
                        <td>
                            <a title="Show results" href="/answer/result/<?= $exercise->getId(); ?>"><i class="fa fa-chart-bar"></i></a>
                            <a data-confirm="Are you sure?" title="Destroy" rel="nofollow" data-method="delete" data-href="/exercise/delete/" data-val="<?= $exercise->getid() ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </section>
</div>