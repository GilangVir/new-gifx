<!-- MAIN-CONTENT -->
<div class="main-content side-content pt-0">
    <div class="main-container container-fluid">
        <div class="inner-body">
            <pre>
                <?php print_r($filePermission); ?>
            </pre>
            <?php if(!$filePermission) : ?>
                <?php require_once __DIR__ . "/403.php";  ?>

            <?php elseif(file_exists($filePermission['filepath'])) : ?>
                <?php require_once $filePermission['filepath']; ?>
                
            <?php else : ?>
                <?php require_once __DIR__ . "/404.php";  ?>
                
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- END MAIN-CONTENT -->