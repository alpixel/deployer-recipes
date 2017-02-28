<?php

namespace Deployer;

/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */

set('ssh_type', 'native');
set('ssh_multiplexing', true);
after('deploy:failed', 'deploy:unlock');

task('maintenance:enable', function () {
    run("mkdir -p {{current}}/web/system/ && rsync -avzh --ignore-errors {{current}}/app/Resources/themes/default/views/page/homepage.html.twig {{current}}/web/system/maintenance.html");
})->desc('Désactivation de la page de maintenance');

task('maintenance:disable', function () {
    run("rm -f {{current}}/web/system/maintenance.html");
})->desc('Désactivation de la page de maintenance');


task('bower:update', function () {
    $bowerPath = __DIR__ . '/../../../bower.json';

    if (!is_file($bowerPath)) {
        throw new InvalidArgumentException("Can't find bower.json");
    }

    $bowerContent = file_get_contents($bowerPath);
    $bowerContent = json_decode($bowerContent);

    $dependencies = [];
    foreach ($bowerContent->dependencies as $key => $version) {
        $dependencies[] = $key;
    }

    $package = null;
    while (!in_array($package, $dependencies)) {
        $package = ask('Quel paquet dois-je mettre à jour ?', null);
    }

    run("cd {{current}} && bower update ".$package);
});

task('bower:list', function () {
    writeln(run("cd {{current}} && bower list"));
});
