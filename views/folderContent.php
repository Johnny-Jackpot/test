<section class="gallery" id="gallery">

<?php foreach ($items['folders'] as $item): ?>
    <div class="item">
        <a href="<?php echo htmlspecialchars($item['link']); ?>">
            <div class="folder">
                <div class="folderThumb"></div>
                <div class="title">
                    <?php echo htmlspecialchars($item['name']); ?>
                </div>
            </div>
        </a>
        <div class="controls">
            <div data-control="delete" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>">Delete</div>
            <div data-control="edit" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>">Edit</div>
        </div>
    </div>
<?php endforeach; ?>



<?php foreach ($items['images'] as $item): ?>
    <div class="item image">
        <a href="<?php echo htmlspecialchars($item['link']); ?>">
            <div class="picture">
                <div class="pictureThumb"></div>
                <div class="title">
                    <?php echo htmlspecialchars($item['name']); ?>
                </div>
            </div>
        </a>
        <div class="controls">
            <div cdata-control="delete" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>">Delete</div>
            <div data-control="edit" 
                data-path="<?php echo htmlspecialchars($item['link']); ?>">Edit</div>
        </div>
    </div>
<?php endforeach; ?>

</section>