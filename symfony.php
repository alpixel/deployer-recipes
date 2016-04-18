<?php

/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */

require 'recipe/symfony3.php';
require __DIR__ . '/common.php';

env('php_fpm', 'php5-fpm');

set('shared_dirs', array_merge(get('shared_dirs'), [
    'var/prod/logs',
    'var/sessions',
    'web/lib',
    'web/upload',
    'web/system',
    'node_modules',
]));

set('shared_files', array_merge(get('shared_files'), [
    'sitemap.xml'
]));

task('deploy:writable', function () {
});

task('deploy:assets', function () {
})->desc('Normalize asset timestamps');

task('deploy:assetic:dump', function () {
    run("cd {{release_path}} && npm install");
    run("cd {{release_path}} && bower install");
    run("cd {{release_path}} && gulp");
})->desc('Dump assets');

task('deploy:cron:enable', function () {
    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console cron:scan --env=\'prod\'');
});
after('deploy:symlink', 'deploy:cron:enable');

task('deploy:database:update', function () {
    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console doctrine:schema:update --env={{env}} --force');
});
after('deploy:vendors', 'deploy:database:update');

task('elastica:populate', function () {
    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console fos:elastica:populate --env=\'prod\'');
});

task('php:restart', function () {
    run('sudo service {{php_fpm}} restart');
});
after('deploy', 'php:restart');

task('elastica:populate', function () {
     run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console fos:elastica:populate --env=\'prod\'');
 });

task('seo:dump', function () {
    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console seo:metatag:patterns --env=\'prod\'');
    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console seo:sitemap --env=\'prod\'');
});