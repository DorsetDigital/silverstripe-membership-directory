<?php

namespace S2Hub\MembershipDirectory\Control;

use PageController;
use S2Hub\MembershipDirectory\Model\DirectoryMember;
use S2Hub\MembershipDirectory\Page\MembershipDirectoryPage;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \S2Hub\Control\MembershipDirectoryPageController
 *
 * @property \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage $dataRecord
 * @method \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage data()
 * @mixin \S2Hub\MembershipDirectory\Page\MembershipDirectoryPage
 */
class MembershipDirectoryPageController extends PageController
{
    private static $allowed_actions = [
        'viewMember'
    ];
    private static $url_handlers = [
        MembershipDirectoryPage::VIEW_SEGMENT . '//$Segment!' => 'viewMember'
    ];

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
}