<?php

namespace S2Hub\MembershipDirectory\Model;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \S2Hub\MembershipDirectory\DirectoryMemberShowcase
 *
 * @property string $Title
 * @property string $Summary
 * @property string $Description
 * @property string $SiteURL
 * @property string $ClientName
 * @property int $Sort
 * @property int $DirectoryMemberID
 * @method \S2Hub\MembershipDirectory\Model\DirectoryMember DirectoryMember()
 * @method \SilverStripe\ORM\DataList|\SilverStripe\Assets\Image[] ShowcaseImages()
 */
class DirectoryMemberShowcase extends DataObject
{
    private static $table_name = 'S2Hub_DirectoryMemberShowcase';
    private static $db = [
        'Title' => 'Varchar',
        'Summary' => 'HTMLText',
        'Description' => 'HTMLText',
        'SiteURL' => 'Varchar',
        'ClientName' => 'Varchar',
        'Sort' => 'Int'
    ];
    private static $has_one = [
        'DirectoryMember' => DirectoryMember::class
    ];
    private static $has_many = [
        'ShowcaseImages' => Image::class
    ];
    private static $owns = [
        'ShowcaseImages'
    ];
    private static $cascade_deletes = [
        'ShowcaseImages'
    ];
    private static $default_sort = 'Sort ASC';
    private static $singular_name = 'Showcase';
    private static $plural_name = 'Showcases';
}
