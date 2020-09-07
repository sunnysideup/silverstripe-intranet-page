<?php

namespace Sunnysideup\IntranetPage;

use Page;





use SilverStripe\Core\Config\Config;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use Sunnysideup\Ecommerce\Pages\CheckoutPage;
use Sunnysideup\PermissionProvider\Api\PermissionProviderFactory;

/**
 * This page is the intranet page
 */
class IntranetPage extends Page
{
    private static $add_action = 'Intranet Page';

    private static $icon = 'resources/app/client/images/treeicons/IntranetPage-file.gif';

    private static $description = 'This page is the intranet page, only accessible to employees';

    private static $can_be_root = true;

    private static $default_parent = IntranetPage::class;

    //private static $allowed_children = array("IntranetPage");

    private static $default_child = IntranetPage::class;

    private static $group_code = 'intranet-members';

    private static $group_name = 'intranet members';

    private static $permission_code = 'INTRANET_USERS';

    private static $role_name = 'intranet member';

    private static $editor_email = 'intranet-member@mysite';

    private static $editor_password = 'asdfsadfasdf';

    /**
     * Standard SS variable.
     */
    private static $singular_name = 'Intranet Page';

    /**
     * Standard SS variable.
     */
    private static $plural_name = 'Intranet Pages';

    private static $defaults = [
        'ProvideComments' => true,
        'ShowInSearch' => false,
    ];

    public function i18n_singular_name()
    {
        return _t('IntranetPage.SINGULARNAME', 'Intranet Page');
    }

    public function i18n_plural_name()
    {
        return _t('IntranetPage.PLURALNAME', 'Intranet Pages');
    }

    public function canCreate($member = null, $context = [])
    {
        if (Security::database_is_ready()) {
            return Permission::checkMember($member, self::$permission_code);
        }
    }

    public function canView($member = null)
    {
        return $this->canCreate($member);
    }

    public function canEdit($member = null, $context = [])
    {
        return $this->canCreate($member);
    }

    public function canDelete($member = null, $context = [])
    {
        return $this->canCreate($member);
    }

    public function getShowInMenus()
    {
        return $this->canView();
    }

    public function ShowInMenus()
    {
        return $this->getShowInMenus();
    }

    public function getShowInSearch()
    {
        return $this->canView();
    }

    public function ShowInSearch()
    {
        return $this->getShowInMenus();
    }

    public function providePermissions()
    {
        $perms[Config::inst()->get(IntranetPage::class, 'permission_code')] = [
            'name' => 'View and Edit Intranet Pages',
            'category' => 'Staff',
            'help' => 'Create/edit/review/delete pages that are only visible to team.',
            'sort' => 0,
        ];
        return $perms;
    }

    public function requireDefaultRecords()
    {
        //bt was here
        parent::requireDefaultRecords();
        if (! CheckoutPage::get()->first()) {
        }
        /**
         * ### @@@@ START REPLACEMENT @@@@ ###
         * update to work with latest version of PermissionProviderFactory
        );
         */
        if (! IntranetPage::get()->count()) {
            $intranetholder = new IntranetPage();
            $intranetholder->Title = 'Intranet';
            $intranetholder->URLSegment = 'Intranet';
            $intranetholder->Content = '<p>Welcome to your Intranet</p>';
            $intranetholder->Status = 'Published';
            $intranetholder->write();
            $intranetholder->publish('Stage', 'Live');
        }
    }
}
