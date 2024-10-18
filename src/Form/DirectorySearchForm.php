<?php

namespace S2Hub\MembershipDirectory\Form;

use S2Hub\MembershipDirectory\Model\DirectoryCategory;
use S2Hub\MembershipDirectory\Page\MembershipDirectoryPage;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;

class DirectorySearchForm extends Form
{

    const DEFAULT_NAME = 'Form';

    /**
     * Include the name search in the form?
     * @config
     * @var bool $show_name_search
     */
    private static $show_name_search = true;

    /**
     * Include the category selector in the form?
     * @config
     * @var bool $show_category_search
     */
    private static $show_category_search = true;

    /**
     * Include a location search in the form?
     * @config
     * @var bool $show_location_search
     */
    private static $show_location_search = true;


    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $fields = FieldList::create();
        if ($this->config()->get('show_name_search')) {
            $fields->push(
                TextField::create(
                    'Name',
                    _t(__CLASS__ . '.SearchFormName', 'Name')
                )
            );
        }

        if (($this->config()->get('show_location_search')) && (MembershipDirectoryPage::singleton()->getMapsKey())) {
            $fields->push(
                TextField::create(
                    'Location',
                    _t(__CLASS__ . '.SearchFormLocation', 'Location')
                )
            );
        }

        if ($this->config()->get('show_category_search')) {
            $fields->push(
              DropdownField::create(
                  'Category',
                  _t(__CLASS__ . '.SearchFormCategory', 'Category'),
                  DirectoryCategory::get()
              )->setEmptyString('')
            );
        }

        $actions = FieldList::create(
            FormAction::create(
                'showResults',
                _t(__CLASS__ . '.SearchFormSubmit', 'Search')
            )
        );

        $this->extend('updateSearchFormFields', $fields);
        parent::__construct($controller, $name, $fields, $actions);
        $this->disableSecurityToken();

    }

}
