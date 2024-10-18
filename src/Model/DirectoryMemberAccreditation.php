<?php

namespace S2Hub\MembershipDirectory\Model;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \S2Hub\MembershipDirectory\Model\DirectoryMemberAccrediation
 *
 * @property string $Title
 * @property int $IconID
 * @method \SilverStripe\Assets\Image Icon()
 * @method \SilverStripe\ORM\ManyManyList|\S2Hub\MembershipDirectory\Model\DirectoryMember[] DirectoryMembers()
 */
class DirectoryMemberAccreditation extends DataObject
{
    private static $table_name = 'S2Hub_DirectoryAccreditation';
    private static $db = [
        'Title' => 'Varchar',
    ];
    private static $default_sort = 'Title ASC';
    private static $belongs_many_many = [
        'DirectoryMembers' => DirectoryMember::class
    ];
    private static $singular_name = 'Directory Accreditation';
    private static $plural_name = 'Directory Accreditation';
    private static $has_one = [
        'Icon' => Image::class
    ];
    private static $owns = [
        'Icon'
    ];
    private static $cascade_deletes = [
        'Icon'
    ];

    public function getCMSFields()
    {
     $fields = parent::getCMSFields();
     $fields->dataFieldByName('Icon')->setFolderName('MemberAccreditations');
     return $fields;
    }
}
