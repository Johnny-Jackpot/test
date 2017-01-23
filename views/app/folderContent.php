<?php require(ROOT . '/views/layouts/main/header.php'); ?>

<?php foreach ($items['folders'] as $item): ?>
    <div class="item">
        <a href="<?php echo htmlspecialchars($item['link']); ?>">
            <div class="folder">
                <div class="folderThumb"></div>
                <div>
                    <?php echo htmlspecialchars($item['name']); ?>
                </div>
            </div>
        </a>
        <div class="controls">
            <div class="glyphicon glyphicon-remove red" 
                aria-hidden="true"
                data-control="delete" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>"></div>
            <div class="glyphicon glyphicon-edit" 
                aria-hidden="true" 
                data-control="edit" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>"></div>
        </div>
    </div>
<?php endforeach; ?>



<?php foreach ($items['images'] as $item): ?>
    <div class="item">
        <a href="<?php echo htmlspecialchars($item['link']); ?>">
            <div class="picture">
                <div class="glyphicon glyphicon-picture custom-glyph" aria-hidden="true"></div>
                <div>
                    <?php echo htmlspecialchars($item['name']); ?>
                </div>
            </div>
        </a>
        <div class="controls">
            <div class="glyphicon glyphicon-remove red" 
                aria-hidden="true"
                data-control="delete" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>"></div>
            <div class="glyphicon glyphicon-edit" 
                aria-hidden="true" 
                data-control="edit" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>"></div>
        </div>
    </div>
<?php endforeach; ?>

<?php require(ROOT . '/views/layouts/main/footer.php');

