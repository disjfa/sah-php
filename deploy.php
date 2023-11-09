<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:disjfa/sah-php.git');

add('shared_files', [
    '.env',
]);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('134.209.197.173')
    ->set('remote_user', 'dimme')
    ->set('deploy_path', '~/sah.dimme.nl/app');

// Hooks

after('deploy:failed', 'deploy:unlock');
