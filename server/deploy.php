<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'SACLMAS');

// Project repository
set('repository', 'git@github.com:eyemovic/aca-saclms.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('saclmas-staging-server')
    ->stage('staging')
    ->hostname('dev-saclmas.jon-api.com')
    ->user('ec2-user')
    ->port(22)
    ->identityFile('~/.ssh/aca-eyemovic.pem')
    ->set('branch', 'develop')
    ->set('deploy_path', '/srv');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');

// customize

set('keep_releases', 1);

task('change_cwd', function () {
    $dir = get('release_path') . DIRECTORY_SEPARATOR . 'server';
    set('release_path', $dir);
    run('cd {{release_path}}');
});

after('deploy:update_code', 'change_cwd');
