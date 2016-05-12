<?php


/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */

/**
 * TRANSLATION
 */
set('shared_dirs', array_merge(get('shared_dirs'), [
    'app/Resources/translations',
]));

task('deploy:translation:download', function () {
    run("php {{release_path}}/" . trim(get('bin_dir'), '/') . "/console alpixel:cms:translations:download --env='prod'");
})->desc('Downloading translations');

after('deploy:vendors', 'deploy:translation:download');
