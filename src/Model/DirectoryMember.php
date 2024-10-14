<?php

namespace S2Hub\MembershipDirectory\Model;

use S2Hub\Page\MembershipDirectoryPage;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Class \S2Hub\MembershipDirectory\DirectoryMember
 *
 * @property string $Title
 * @property string $URLSegment
 * @property string $Address
 * @property string $Phone
 * @property string $Email
 * @property string $Latitude
 * @property string $Longitude
 * @property string $Description
 * @property int $MemberID
 * @property int $LogoImageID
 * @method \SilverStripe\Security\Member Member()
 * @method \SilverStripe\Assets\Image LogoImage()
 * @method \SilverStripe\ORM\DataList|\S2Hub\MembershipDirectory\Model\DirectoryMemberShowcase[] Showcases()
 * @method \SilverStripe\ORM\ManyManyList|\S2Hub\MembershipDirectory\Model\DirectoryCategory[] Categories()
 */
class DirectoryMember extends DataObject
{
    private static $table_name = 'S2Hub_DirectoryMember';
    private static $db = [
        'Title' => 'Varchar',
        'URLSegment' => 'Varchar',
        'Address' => 'Text',
        'Phone' => 'Varchar',
        'Email' => 'Varchar',
        'Latitude' => 'Varchar',
        'Longitude' => 'Varchar',
        'Description' => 'HTMLText',
    ];
    private static $has_one = [
        'Member' => Member::class,
        'LogoImage' => Image::class
    ];
    private static $has_many = [
        'Showcases' => DirectoryMemberShowcase::class
    ];
    private static $owns = [
        'LogoImage'
    ];
    private static $belongs_many_many = [
        'Categories' => DirectoryCategory::class
    ];
    private static $cascade_deletes = [
        'Showcases',
        'LogoImage'
    ];
    private static $indexes = [
        'URLSegment' => true
    ];
    private static $default_sort = 'Title ASC';

    /**
     * @return string
     */
    public function Link()
    {
        $directoryPage = MembershipDirectoryPage::get()->first();
        if (!$directoryPage) {
            return Director::baseURL();
        }

        return Controller::join_links([
            $directoryPage->Link(),
            MembershipDirectoryPage::VIEW_SEGMENT,
            $this->URLSegment
        ]);
    }

    /**
     * @param $segment
     * @return DirectoryMember|null
     */
    public static function getByURLSegment($segment)
    {
        return self::get_one(self::class, ['URLSegment' => $segment]);
    }
}