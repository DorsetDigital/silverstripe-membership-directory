<?php

namespace S2Hub\MembershipDirectory\Page;

use S2Hub\MembershipDirectory\Control\MembershipDirectoryPageController;
use SilverStripe\Core\Environment;

/**
 * Class \S2Hub\Page\MembershipDirectoryPage
 *
 */
class MembershipDirectoryPage extends \Page
{
    const VIEW_SEGMENT = 'view';
    private static $table_name = 'S2Hub_MembershipDirectoryPage';
    private static $controller_name = MembershipDirectoryPageController::class;
    private static $singular_name = 'Membership Directory Page';
    private static $plural_name = 'Membership Directory Pages';
    private static $description = 'Main index page for the membership directory';

    /**
     * Turn on / off location maps
     * @config
     * @var bool $show_maps
     */
    private static $show_maps = true;

    private static $allow_frontend_creation = false;

    private static $moderate_edits = true;

    /**
     * Enable / disable member showcases
     * @config
     * @var bool $allow_showcases
     */
    private static $allow_showcases = true;

    /**
     * Check if we will be showing maps, based on the configuration variable
     * and presence of the required maps variables
     * @return bool
     */
    public function getShowMaps()
    {
        $show_maps = $this->config()->get('show_maps');
        return ($show_maps && $this->getMapsKey());
    }

    /**
     * Retrieve the maps key from the environment (or from an extension to the page)
     * @return mixed
     */
    public function getMapsKey()
    {
        $mapsKey = Environment::getEnv('MAPS_API_KEY');
        $this->extend('updateMapsKey', $mapsKey);
        return $mapsKey;
    }
}
