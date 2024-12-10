<h2><?= __('Configure log paths') ?></h2>

<?php foreach ((array)json_decode(get_option('logPaths')) as $option => $path): ?>
    <div class="field">
        <div class="two columns alpha">
            <?php echo get_view()->formLabel($option, $option); ?>
        </div>
        <div class="inputs five columns omega">
            <p class="explanation">
                <?php echo __('Path to the file:'); ?>
            </p>
            <?php echo get_view()->formText($option, $path); ?>
        </div>
    </div>
<?php endforeach; ?>

<h2><?= __('Config Access rights') ?></h2>
<div class="field">
    <div class="two columns alpha">
        <?php echo get_view()->formLabel('belogs-rolesACL', "Backend Logs Access"); ?>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('Select userroles allowed to see the Logs'); ?></p>

        <table id="table">
            <thead>
                <tr>
                    <th class="boxes"><?php echo __('Role'); ?></th>
                    <th class="boxes"><?php echo __('Show Logs'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $userRoles = json_decode(get_option("belogs_rolesACL"));
                    
                    // display table content
                    foreach ($userRoles as $role=>$option) {
                        echo '<tr>';
                        echo '<td class="column-user">' . __($role) . '</td>';
                        echo '<td class="boxes">' . get_view()->formCheckbox('belogs-rolesACL[]', $role, ['id' => 'belogs-rolesACL-'.$role.'-id'],  $option ? [$role] : []) . '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>