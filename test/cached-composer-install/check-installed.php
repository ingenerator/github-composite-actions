<?php

$expect_installed = match (getenv('EXPECT_DEV_PACKAGES')) {
    'installed' => [
        'psr/log' => true,
        'psr/cache' => true,
    ],
    'not-installed' => [
        'psr/log' => true,
        'psr/cache' => false,
    ],
    default => throw new InvalidArgumentException('Define EXPECT_DEV_PACKAGES as installed|not-installed')
};

require_once './vendor/autoload.php';

$actual = [
    'psr/log' => interface_exists(\Psr\Log\LoggerInterface::class),
    'psr/cache' => interface_exists(\Psr\Cache\CacheItemPoolInterface::class),
];

if ($actual === $expect_installed) {
    echo "Correct packages were installed: ";
    print_r($actual);
    exit;
}

print "Installed packages: ";
print_r($actual);
print "Did not match expected: ";
print_r($expect_installed);
exit(1);
