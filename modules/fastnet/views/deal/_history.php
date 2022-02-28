<?php
use app\components\Helper;
?>
<table class="table-condensed">
    <thead>
    <tr>
        <th>Ամսաթիվ</th>
        <th>Վճարում</th>
        <th>Բալանս</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if (!empty($history)) : ?>
        <?php foreach ($history as $log) : ?>
            <tr style="background: <?=$log['changeTariff'] ? 'orange' : ''?>">
                <td><b><?= Helper::formatDate($log['date'], false, true) ?></b></td>
                <td><?= $log['pay'] ?></td>
                <td><?= $log['balance'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
