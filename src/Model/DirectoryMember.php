<?php

namespace S2Hub\MembershipDirectory\Model;

use S2Hub\MembershipDirectory\Page\MembershipDirectoryPage;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\SearchableDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\View\Parsers\URLSegmentFilter;

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
 * @method \SilverStripe\ORM\ManyManyList|\S2Hub\MembershipDirectory\Model\DirectoryMemberAccreditation[] Accreditations()
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
    private static $many_many = [
        'Accreditations' => DirectoryMemberAccreditation::class
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
    private static $singular_name = 'Directory Member';
    private static $plural_name = 'Directory Members';


    /**
     * @todo - Refactor this so the fieldset is built manually
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title', $this->fieldLabel('Title')),
            SiteTreeURLSegmentField::create('URLSegment', $this->fieldLabel('URLSegment'))
                ->setDefaultURL($this->generateURLSegment(
                    _t(__CLASS__ . '.NewMember', 'New Member')
                )),
            SearchableDropdownField::create(
                'MemberID',
                $this->fieldLabel('Link to system member'),
                Member::get()
            )->setDescription(_t(__CLASS__ . '.LinkMemberDescription',
                    'Linking to a system member will allow functionality such as member-editing of directory entries, etc.'
                ))
        ]);

        if (MembershipDirectoryPage::config()->get('allow_showcases') === true) {
            $fields->addFieldsToTab('Root.Showcases', [
                GridField::create('Showcases', $this->fieldLabel('Showcases'), $this->Showcases(),
                    GridFieldConfig_RecordEditor::create())
            ]);
        }

        $fields->dataFieldByName('LogoImage')->setFolderName('MemberLogos');



        return $fields;
    }

    /**
     * Get a link to the listing page, assuming a MembershipDirectoryPage is in the site tree
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


    public function generateURLSegment($title)
    {
        $filter = URLSegmentFilter::create();
        $filteredTitle = $filter->filter($title);

        // Fallback to generic page name if path is empty (= no valid, convertable characters)
        if (!$filteredTitle || $filteredTitle == '-' || $filteredTitle == '-1') {
            $filteredTitle = "directorymember-$this->ID";
        }

        // Hook for extensions
        $this->extend('updateURLSegment', $filteredTitle, $title);

        return $filteredTitle;
    }

}
