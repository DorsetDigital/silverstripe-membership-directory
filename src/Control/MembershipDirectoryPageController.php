<?php

namespace S2Hub\MembershipDirectory\Control;

use PageController;
use S2Hub\MembershipDirectory\Form\DirectorySearchForm;
use S2Hub\MembershipDirectory\Model\DirectoryMember;
use S2Hub\MembershipDirectory\Page\MembershipDirectoryPage;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;

/**
 * Class \S2Hub\Control\MembershipDirectoryPageController
 *
 * @property \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage $dataRecord
 * @method \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage data()
 * @mixin \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage
 * @mixin \BiffBangPow\Extension\MemberDirectoryControllerExtension
 */
class MembershipDirectoryPageController extends PageController
{
    private static $allowed_actions = [
        'viewMember',
        'dosearch'
    ];
    private static $url_handlers = [
        MembershipDirectoryPage::VIEW_SEGMENT . '//$Segment!' => 'viewMember'
    ];

    public function index()
    {
        Requirements::javascript('s2hub/silverstripe-membership-directory:client/dist/javascript/directory_main.js', [
            'type' => false
        ]);
        Requirements::css('s2hub/silverstripe-membership-directory:client/dist/css/directory_main.css');
        return $this->render();
    }

    public function viewMember(HTTPRequest $request)
    {
        $URLSegment = $request->param('Segment');
        if ($URLSegment == '') {
            return $this->httpError(404);
        }
        $this->MemberListing = DirectoryMember::getByURLSegment($URLSegment);
        if (!$this->MemberListing) {
            return $this->httpError(404);
        }
        return $this->render();
    }

    /**
     * @return DirectorySearchForm
     */
    public function SearchForm()
    {
        $form = DirectorySearchForm::create($this);
        $form->setFormAction($this->Link('dosearch'));
        return $form;
    }

    public function dosearch(HTTPRequest $request) {
        if (!$request->isAjax()) {
            return $this->httpError(404);
        }

        $filters = [];

        if ($request->postVar('Name')) {
            $filters['Title:PartialMatchFilter'] = $request->postVar('Name');
        }

        if ($request->postVar('Location') && MembershipDirectoryPage::singleton()->getMapsKey()) {

        }

        if ($request->postVar('Category')) {
            $filters['Categories.ID'] = $request->postVar('Category');
        }

        $search = DirectoryMember::get();
        if (count($filters) > 1) {
            $search = $search->filter($filters);
        }

        return $this->render(['Results' => $search]);
    }

}
