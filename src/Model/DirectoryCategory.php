<?php

namespace S2Hub\MembershipDirectory\Model;

use SilverStripe\ORM\DataObject;

/**
 * Class \S2Hub\MembershipDirectory\Model\DirectoryCategory
 *
 * @property string $Title
 * @method \SilverStripe\ORM\ManyManyList|\S2Hub\MembershipDirectory\Model\DirectoryMember[] DirectoryMembers()
 */
class DirectoryCategory extends DataObject
{
    private static $table_name = 'S2Hub_DirectoryCategory';
    private static $db = [
        'Title' => 'Varchar',
    ];
    private static $default_sort = 'Title ASC';
    private static $many_many = [
        'DirectoryMembers' => DirectoryMember::class
    ];
    private static $singular_name = 'Directory Category';
    private static $plural_name = 'Directory Categories';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('DirectoryMembers');
        return $fields;
    }
}
