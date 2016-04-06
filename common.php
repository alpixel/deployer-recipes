<?php

/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */

task('maintenance:enable', function () {
    run("mkdir -p {{current}}/web/system/ && rsync -avzh --ignore-errors {{current}}/app/Resources/themes/default/views/page/homepage.html.twig {{current}}/web/system/maintenance.html");
})->desc('Désactivation de la page de maintenance');

task('maintenance:disable', function () {
    run("rm -f {{current}}/web/system/maintenance.html");
})->desc('Désactivation de la page de maintenance');
