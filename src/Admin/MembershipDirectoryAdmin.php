<?php

namespace S2Hub\MembershipDirectory\Admin;

use S2Hub\MembershipDirectory\Model\DirectoryCategory;
use S2Hub\MembershipDirectory\Model\DirectoryMember;
use S2Hub\MembershipDirectory\Model\DirectoryMemberAccreditation;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \S2Hub\Admin\MembershipDirectoryAdmin
 *
 */
class MembershipDirectoryAdmin extends ModelAdmin
{
    private static $managed_models = [
        DirectoryMember::class,
        DirectoryCategory::class,
        DirectoryMemberAccreditation::class
    ];
    private static $url_segment = 'membership-directory';
    private static $menu_title = 'Membership Directory';
    private static $menu_icon_class = 'font-icon-address-card';
}
