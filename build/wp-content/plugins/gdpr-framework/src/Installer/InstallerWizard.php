<?php

namespace Codelight\GDPR\Installer;

/**
 * Handle the installer wizard pages
 *
 * Class InstallerWizard
 *
 * @package Codelight\GDPR\Installer
 */
class InstallerWizard
{
    /**
     * InstallerWizard constructor.
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'registerWizardPage']);
    }

    /**
     * Register the installer page with WordPress
     */
    public function registerWizardPage()
    {
        add_dashboard_page( '', '', 'manage_options', 'gdpr-setup', '' );
    }

    /**
     * Check if we are already on the installer page
     *
     * @return bool
     */
    public function isWizardPage()
    {
        return isset($_GET['page']) && 'gdpr-setup' === $_GET['page'];
    }
}