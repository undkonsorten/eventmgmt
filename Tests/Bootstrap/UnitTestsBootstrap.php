<?php
(function () {
    $vendorDir = getenv('VENDOR_DIR') ?: (\Composer\Factory::create(new \Composer\IO\NullIO()))->getConfig()->get('vendor-dir');
    /** @noinspection PhpIncludeInspection */
    require_once $vendorDir . '/typo3/testing-framework/Resources/Core/Build/UnitTestsBootstrap.php';
})();
