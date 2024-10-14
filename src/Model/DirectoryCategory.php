<?php

namespace S2Hub\MembershipDirectory\Model;

use SilverStripe\ORM\DataObject;

/**
 * Class \S2Hub\MembershipDirectory\Model\DirectoryCategory
 *
 * @property string $Title
 * @method \SilverStripe\ORM\ManyManyList|\S2Hub\MembershipDirectory\Model\DirectoryMember[] DirectoryMember()
 */
class DirectoryCategory extends DataObject
{
    private static $table_name = 'S2Hub_DirectoryCategory';
    private static $db = [
        'Title' => 'Varchar',
    ];
    private static $default_sort = 'Title ASC';
    private static $many_many = [
        'DirectoryMember' => DirectoryMember::class
    ];
    private static $singular_name = 'Directory Category';
    private static $plural_name = 'Directory Categories';
}