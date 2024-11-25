<div class="field">
    <div class="two columns alpha">
        <?php echo get_view()->formLabel('some-element', __('Some Element')); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation">
            <?php echo __('Any explanatory text about the form element.'); ?>
        </p>
        <?php echo get_view()->formInput('some-element', $someElementValue); ?>
    </div>
</div>