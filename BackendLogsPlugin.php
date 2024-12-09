<?php
/**
 * @package BackendLogs
 * @copyright Copyright 2024, Christos Sidiropoulos
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 */
class BackendLogsPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = [
        'install',
        'uninstall',
        'config',
        'config_form',
        'define_acl',
    ];

    protected $_filters = [
        'admin_navigation_main',
    ];

    protected $_options = [
        'logPaths' => [
            'omekaLogFile' => '/app/application/logs/errors.log',
            'apacheErrorLogFile' => '/var/log/apache2/error.log',
            'apacheAccessLogFile' => '/var/log/apache2/access.log',
            'apacheOtherVHALogFile' => '/var/log/apache2/other_vhosts_access.log',
        ]
    ];

    /**
     *  Hooks in the proccess of installing the plugin.
     */
    public function hookInstall(): void
    {
        // Add default values to plugin options as 'logPaths' array:
        set_option('logPaths', json_encode($this->_options['logPaths']));
    }

    /**
     *  Hooks in the proccess of uninstalling the plugin.
     */
    public function hookUninstall(): void
    {
        // Remove default plugin options:
        delete_option('logPaths');
    }

    /**
     * Display the configuration form.
     */
    public function hookConfigForm(): void
    {
        include 'views/admin/config-form.php';
    }

    /**
     * Process the configuration form submission.
     */
    public function hookConfig($args): void
    {
        $logPaths = json_decode(get_option('logPaths'), true);
        foreach ($logPaths as $option => $path) {
            $logPaths[$option] = trim($args['post'][$option]);
        }
        set_option('logPaths', json_encode($logPaths));
    }

    /**
     * Define the plugin's Access Control List.
     * 
     * @param array $args
     */
    public function hookDefineAcl($args): void
    {
        $acl = $args['acl']; // get the Zend_Acl

        $acl->addResource('BackendLogs_Index');

        $acl->allow(array('super', 'admin'), array('BackendLogs_Index'));
        $acl->deny(null, array('BackendLogs_Index'));
    }

    /**
     * Add the BackendLogs link to the admin main navigation.
     * 
     * @param array Navigation array.
     * @return array Filtered navigation array.
     */
    public function filterAdminNavigationMain($nav): array
    {
        $nav[] = array(
            'label' => __('Backend Logs'),
            'uri' => url('backend-logs'),
            'resource' => 'BackendLogs_Index',
            'privilege' => 'index'
        );
        return $nav;
    }
}
