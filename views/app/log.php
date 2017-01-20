<?php require(ROOT . '/views/layouts/main/header.php'); ?>

<div class="container-fluid">
    <table class="table table-hover custom-table">
        <tr>
            <th>Action type</th>
            <th>Target</th>
            <th>Date/Time</th>
        </tr>
        <?php foreach ($log as $record): ?>
            <tr>
                <td><?php echo htmlspecialchars($record['type']); ?></td>
                <td><?php echo htmlspecialchars($record['target']); ?></td>
                <td><?php echo htmlspecialchars($record['date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require(ROOT . '/views/layouts/main/footer.php');