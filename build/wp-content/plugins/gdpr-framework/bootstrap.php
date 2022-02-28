<?php

/**
 * Set up config object, store plugin URL and path there
 * along with various other items
 */
\Codelight\GDPR\Container::getInstance()->bindIf('config', function () {
    return new \Codelight\GDPR\Config(['plugin' => ['url' => plugin_dir_url(__FILE__), 'path' => plugin_dir_path(__FILE__), 'template_path' => plugin_dir_path(__FILE__) . 'views/'], 'help' => ['url' => 'https://www.data443.com/gdpr-framework/']]);
}, \true);
/**
 * Set up the application container
 *
 * @param string                   $abstract
 * @param array                    $parameters
 * @param \Codelight\GDPR\Container $container
 *
 * @return \Codelight\GDPR\Container|mixed
 */
function gdpr($abstract = null, $parameters = [], \Codelight\GDPR\Container $container = null)
{
    $container = $container ?: \Codelight\GDPR\Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract) ? $container->makeWith($abstract, $parameters) : $container->makeWith("gdpr.{$abstract}", $parameters);
}
/**
 * Start the plugin on plugins_loaded at priority 0.
 */
add_action('plugins_loaded', function () use($gdpr_error) {
    new \Codelight\GDPR\Updater\Updater();
    new \Codelight\GDPR\Setup();
}, 0);
