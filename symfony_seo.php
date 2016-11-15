<?php

namespace Deployer;

/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */

/**
 * SEO
 */
task('seo:meta-tags', function () {
    run("php {{release_path}}/" . trim(get('bin_dir'), '/') . "/console alpixel:seo:metatag:dump --env='prod'");
})->desc('Dump meta tags');

task('seo:sitemap', function () {
    run("php {{release_path}}/" . trim(get('bin_dir'), '/') . "/console alpixel:cms:sitemap --env='prod'");
})->desc('Dump sitemap');

after('deploy:vendors', 'seo:meta-tags');
after('deploy:vendors', 'seo:sitemap');
