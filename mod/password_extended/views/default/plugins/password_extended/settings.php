<p>
<?php
    Global $CONFIG;

    $plugin = elgg_extract('entity', $vars);

    $noyes_options = [
        'no' => elgg_echo('option:no'),
        'yes' => elgg_echo('option:yes'),
    ];
    $yesno_options = array_reverse($noyes_options);

?>

    <!-- Symbols -->
<div class="elgg-module elgg-module-inline">
    <div class="elgg-head"><h3><?= elgg_echo('password_extended:settings') ?></h3></div>
    <div class="elgg-body">
        <table class="elgg-table">
            <tbody>
            <!-- Symbols -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_symbols') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[use_symbols]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->use_symbols,
                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_symbols_value') ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[use_symbols_value]',
                        'maxlength' => 1,
                        'style' => "width: 50px;",
                        'value' => ($plugin->use_symbols_value) ? $plugin->use_symbols_value: 1,
                    ]);

                    ?></td>
            </tr>

            <!-- Numbers -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_numbers') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[use_numbers]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->use_numbers,
                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_numbers_value') ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[use_numbers_value]',
                        'maxlength' => 1,
                        'style' => "width: 50px;",
                        'value' => ($plugin->use_numbers_value) ? $plugin->use_numbers_value: 1,
                    ]);

                    ?></td>
            </tr>
            <!-- lowercase -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_lowercase') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[use_lowercase]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->use_lowercase,

                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_lowercase_value') ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[use_lowercase_value]',
                        'maxlength' => 1,
                        'style' => "width: 50px;",
                        'value' => ($plugin->use_lowercase_value) ? $plugin->use_lowercase_value: 1,
                    ]);

                    ?></td>
            </tr>
            <!-- uppercase -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_uppercase') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[use_uppercase]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->use_uppercase,

                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:use_uppercase_value') ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[use_uppercase_value]',
                        'maxlength' => 1,
                        'style' => "width: 50px;",
                        'value' => ($plugin->use_uppercase_value) ? $plugin->use_uppercase_value: 1,
                    ]);

                    ?></td>
            </tr>

            <!-- password_min_lenght  -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:password_min_lenght') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[password_lenght_min]',
                        'options_values' => $yesno_options,
                        'value' => ($CONFIG->password_lenght_min) ? $plugin->password_lenght_min : 'yes',
                       // 'disabled' => ($CONFIG->min_password_length) ? 'disabled' : 'enabled',
                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:password_min_lenght_value') ?> <?php echo $CONFIG->min_password_length ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[password_min_lenght_value]',
                        'maxlength' => 1,
                        'style' => "width: 50px;",
                        'value' => ($plugin->password_min_lenght_value) ? $plugin->password_min_lenght_value : $CONFIG->min_password_length,
                    ]);

                    ?></td>
            </tr>
            <!-- password_max_lenght  -->
            <tr>
                <td><?= elgg_echo('password_extended:settings:password_max_lenght') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[max_lenght_password]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->max_lenght_password,
                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            <tr>
                <td><?= elgg_echo('password_extended:settings:password_max_lenght_value') ?></td>
                <td><?php
                    echo elgg_view('input/text', [
                        'name' => 'params[password_max_lenght_value]',
                        'maxlength' => 2,
                        'style' => "width: 50px;",
                        'value' => ($password_max_lenght_value) ? $password_max_lenght_value: 20,
                    ]);

                    ?></td>
            </tr>
            <!--
            <tr>
                <td><?= elgg_echo('password_extended:settings:password_expired') ?></td>
                <td><?php
                    echo elgg_view('input/dropdown', [
                        'name' => 'params[expired_password]',
                        'options_values' => $yesno_options,
                        'value' => $plugin->expired_password,
                        'class' => 'mls',
                    ]);

                    ?></td>
            </tr>
            -->
            </tbody>
        </table>
    </div>
</div>

