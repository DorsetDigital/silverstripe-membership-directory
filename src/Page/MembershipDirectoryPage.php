<?php

namespace S2Hub\MembershipDirectory\Page;

use S2Hub\MembershipDirectory\Control\MembershipDirectoryPageController;

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
}