<?php
namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use Yii;

/**
 * Creates base rbac authorization data for our application.
 * -----------------------------------------------------------------------------
 * Creates 6 roles:
 *
 * - theCreator : you, developer of this site (super admin)
 * - admin      : your direct clients, administrators of this site
 * - editor     : editor of this site
 * - support    : support staff
 * - premium    : premium member of this site
 * - member     : user of this site who has registered his account and can log in
 *
 * Creates 12 permissions:
 *
 * - usePremiumContent  : allows premium members to use premium content
 * - createArticle      : allows editor+ roles to create articles
 * - updateOwnArticle   : allows editor+ roles to update own articles
 * - updateArticle      : allows admin+ roles to update all articles
 * - deleteArticle      : allows admin+ roles to delete articles
 * - adminArticle       : allows admin+ roles to manage articles
 * - createGallery      : allows editor+ roles to create articles
 * - updateOwnGallery   : allows editor+ roles to update own articles
 * - updateGallery      : allows admin+ roles to update all articles
 * - deleteGallery      : allows admin+ roles to delete articles
 * - adminGallery       : allows admin+ roles to manage articles
 * - manageUsers        : allows admin+ roles to manage users (CRUD plus role assignment)
 *
 * Creates 1 rule:
 *
 * - AuthorRule : allows editor+ roles to update their own content
 */
class RbacController extends Controller
{
    /**
     * Initializes the RBAC authorization data.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //---------- RULES ----------//

        // add the rule
        $rule = new \common\rbac\rules\AuthorRule;
        $userRule = new \common\rbac\rules\UserRule;
        $auth->add($rule);
        $auth->add($userRule);

        //---------- PERMISSIONS ----------//

        // add "usePremiumContent" permission
        $usePremiumContent = $auth->createPermission('usePremiumContent');
        $usePremiumContent->description = 'Allows premium+ roles to use premium content';
        $auth->add($usePremiumContent);


        // ---- User ---//

        // add "manageUsers" permission
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Allows admin+ roles to manage users';
        $auth->add($manageUsers);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Allows member+ roles to update Users';
        $auth->add($updateUser);
        
        // add the "updateOwnUser" permission and associate the rule with it.
        $updateOwnUser = $auth->createPermission('updateOwnUser');
        $updateOwnUser->description = 'Update own user';
        $updateOwnUser->ruleName = $userRule->name;
        $auth->add($updateOwnUser);

        $auth->addChild($updateOwnUser, $updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Allows member+ roles to delete Users';
        $auth->add($deleteUser);
        
        // add the "deleteOwnUser" permission and associate the rule with it.
        $deleteOwnUser = $auth->createPermission('deleteOwnUser');
        $deleteOwnUser->description = 'Update own user';
        $deleteOwnUser->ruleName = $userRule->name;
        $auth->add($deleteOwnUser);

        $auth->addChild($deleteOwnUser, $deleteUser);


        //----- Article ---//
        
        // add "createArticle" permission
        $createArticle = $auth->createPermission('createArticle');
        $createArticle->description = 'Allows editor+ roles to create articles';
        $auth->add($createArticle);

        // add "deleteArticle" permission
        $deleteArticle = $auth->createPermission('deleteArticle');
        $deleteArticle->description = 'Allows admin+ roles to delete articles';
        $auth->add($deleteArticle);

        // add "adminArticle" permission
        $adminArticle = $auth->createPermission('adminArticle');
        $adminArticle->description = 'Allows admin+ roles to manage articles';
        $auth->add($adminArticle);  

        // add "updateArticle" permission
        $updateArticle = $auth->createPermission('updateArticle');
        $updateArticle->description = 'Allows editor+ roles to update articles';
        $auth->add($updateArticle);

        // add the "updateOwnArticle" permission and associate the rule with it.
        $updateOwnArticle = $auth->createPermission('updateOwnArticle');
        $updateOwnArticle->description = 'Update own article';
        $updateOwnArticle->ruleName = $rule->name;
        $auth->add($updateOwnArticle);

        // "updateOwnArticle" will be used from "updateArticle"
        $auth->addChild($updateOwnArticle, $updateArticle);

        // add the "deleteOwnArticle" permission and associate the rule with it.
        $deleteOwnArticle = $auth->createPermission('deleteOwnArticle');
        $deleteOwnArticle->description = 'Delete own article';
        $deleteOwnArticle->ruleName = $rule->name;
        $auth->add($deleteOwnArticle);

        // "deleteOwnArticle" will be used from "deleteArticle"
        $auth->addChild($deleteOwnArticle, $deleteArticle);




        // add "createGallery" permission
        $createGallery = $auth->createPermission('createGallery');
        $createGallery->description = 'Allows editor+ roles to create galleries';
        $auth->add($createGallery);

        // add "deleteGallery" permission
        $deleteGallery = $auth->createPermission('deleteGallery');
        $deleteGallery->description = 'Allows admin+ roles to delete galleries';
        $auth->add($deleteGallery);

        // add "adminGallery" permission
        $adminGallery = $auth->createPermission('adminGallery');
        $adminGallery->description = 'Allows admin+ roles to manage galleries';
        $auth->add($adminGallery);

        // add "updateGallery" permission
        $updateGallery = $auth->createPermission('updateGallery');
        $updateGallery->description = 'Allows editor+ roles to update galleries';
        $auth->add($updateGallery);

        // add the "updateOwnGallery" permission and associate the rule with it.
        $updateOwnGallery = $auth->createPermission('updateOwnGallery');
        $updateOwnGallery->description = 'Update own gallery';
        $updateOwnGallery->ruleName = $rule->name;
        $auth->add($updateOwnGallery);

        // "updateOwnGallery" will be used from "updateGallery"
        $auth->addChild($updateOwnGallery, $updateGallery);


        // add the "deleteOwnGallery" permission and associate the rule with it.
        $deleteOwnGallery = $auth->createPermission('deleteOwnGallery');
        $deleteOwnGallery->description = 'Delete own gallery';
        $deleteOwnGallery->ruleName = $rule->name;
        $auth->add($deleteOwnGallery);

        // "deleteOwnGallery" will be used from "deleteGallery"
        $auth->addChild($deleteOwnGallery, $deleteGallery);
        
        
        
        // --------- Organisations -------//
        // add "createOrganisation" permission
        $createOrganisation = $auth->createPermission('createOrganisation');
        $createOrganisation->description = 'Allows member+ roles to create Organisations';
        $auth->add($createOrganisation);

        // add "deleteOrganisation" permission
        $deleteOrganisation = $auth->createPermission('deleteOrganisation');
        $deleteOrganisation->description = 'Allows admin+ roles to delete Organisations';
        $auth->add($deleteOrganisation);

        // add "adminOrganisation" permission
        $adminOrganisation = $auth->createPermission('adminOrganisation');
        $adminOrganisation->description = 'Allows admin+ roles to manage Organisations';
        $auth->add($adminOrganisation);

        // add "updateOrganisation" permission
        $updateOrganisation = $auth->createPermission('updateOrganisation');
        $updateOrganisation->description = 'Allows member+ roles to update Organisations';
        $auth->add($updateOrganisation);

        // add the "updateOwnOrganisation" permission and associate the rule with it.
        $updateOwnOrganisation = $auth->createPermission('updateOwnOrganisation');
        $updateOwnOrganisation->description = 'Update member to update own Organisation';
        $updateOwnOrganisation->ruleName = $rule->name;
        $auth->add($updateOwnOrganisation);

        // "updateOwnOrganisation" will be used from "updateOrganisation"
        $auth->addChild($updateOwnOrganisation, $updateOrganisation);

        // add the "updateOwnPlayer" permission and associate the rule with it.
        $deleteOwnOrganisation = $auth->createPermission('deleteOwnOrganisation');
        $deleteOwnOrganisation->description = 'Update member to delete own Organisation';
        $deleteOwnOrganisation->ruleName = $rule->name;
        $auth->add($deleteOwnOrganisation);

        $auth->addChild($deleteOwnOrganisation, $deleteOrganisation);


        // --------- Tournaments -------//
        // add "createTournament" permission
        $createTournament = $auth->createPermission('createTournament');
        $createTournament->description = 'Allows member+ roles to create Tournaments';
        $auth->add($createTournament);

        // add "deleteTournament" permission
        $deleteTournament = $auth->createPermission('deleteTournament');
        $deleteTournament->description = 'Allows admin+ roles to delete Tournaments';
        $auth->add($deleteTournament);

        // add "adminTournament" permission
        $adminTournament = $auth->createPermission('adminTournament');
        $adminTournament->description = 'Allows admin+ roles to manage Tournaments';
        $auth->add($adminTournament);

        // add "updateTournament" permission
        $updateTournament = $auth->createPermission('updateTournament');
        $updateTournament->description = 'Allows member+ roles to update Tournaments';
        $auth->add($updateTournament);

        // add the "updateOwnTournament" permission and associate the rule with it.
        $updateOwnTournament = $auth->createPermission('updateOwnTournament');
        $updateOwnTournament->description = 'Update member to update own Tournament';
        $updateOwnTournament->ruleName = $rule->name;
        $auth->add($updateOwnTournament);

        // "updateOwnTournament" will be used from "updateTournament"
        $auth->addChild($updateOwnTournament, $updateTournament);

        // add the "updateOwnPlayer" permission and associate the rule with it.
        $deleteOwnTournament = $auth->createPermission('deleteOwnTournament');
        $deleteOwnTournament->description = 'Update member to delete own Tournament';
        $deleteOwnTournament->ruleName = $rule->name;
        $auth->add($deleteOwnTournament);

        $auth->addChild($deleteOwnTournament, $deleteTournament);
        

        // --------- Player -------//
        // add "createOrganisation" permission
        $createPlayer = $auth->createPermission('createPlayer');
        $createPlayer->description = 'Allows member+ roles to create Players';
        $auth->add($createPlayer);

        // add "deletePlayer" permission
        $deletePlayer = $auth->createPermission('deletePlayer');
        $deletePlayer->description = 'Allows admin+ roles to delete Players';
        $auth->add($deletePlayer);

        // add "adminPlayer" permission
        $adminPlayer = $auth->createPermission('adminPlayer');
        $adminPlayer->description = 'Allows admin+ roles to manage Players';
        $auth->add($adminPlayer);

        // add "updatePlayer" permission
        $updatePlayer = $auth->createPermission('updatePlayer');
        $updatePlayer->description = 'Allows member+ roles to update Players';
        $auth->add($updatePlayer);

        // add the "updateOwnPlayer" permission and associate the rule with it.
        $updateOwnPlayer = $auth->createPermission('updateOwnPlayer');
        $updateOwnPlayer->description = 'Update member to update own Player';
        $updateOwnPlayer->ruleName = $rule->name;
        $auth->add($updateOwnPlayer);

        // "updateOwnPlayer" will be used from "updatePlayer"
        $auth->addChild($updateOwnPlayer, $updatePlayer);


        // add the "updateOwnPlayer" permission and associate the rule with it.
        $deleteOwnPlayer = $auth->createPermission('deleteOwnPlayer');
        $deleteOwnPlayer->description = 'Update member to delete own Player';
        $deleteOwnPlayer->ruleName = $rule->name;
        $auth->add($deleteOwnPlayer);
        
        $auth->addChild($deleteOwnPlayer, $deletePlayer);


        // --------- Events and Locations -------//
        // add "createOrganisation" permission
        $createEventsAndLocations = $auth->createPermission('createEventsAndLocations');
        $createEventsAndLocations->description = 'Allows member+ roles to create EventsAndLocationss';
        $auth->add($createEventsAndLocations);

        // add "deleteEventsAndLocations" permission
        $deleteEventsAndLocations = $auth->createPermission('deleteEventsAndLocations');
        $deleteEventsAndLocations->description = 'Allows admin+ roles to delete EventsAndLocationss';
        $auth->add($deleteEventsAndLocations);

        // add "adminEventsAndLocations" permission
        $adminEventsAndLocations = $auth->createPermission('adminEventsAndLocations');
        $adminEventsAndLocations->description = 'Allows admin+ roles to manage EventsAndLocationss';
        $auth->add($adminEventsAndLocations);

        // add "updateEventsAndLocations" permission
        $updateEventsAndLocations = $auth->createPermission('updateEventsAndLocations');
        $updateEventsAndLocations->description = 'Allows member+ roles to update EventsAndLocationss';
        $auth->add($updateEventsAndLocations);

        // add the "updateOwnEventsAndLocations" permission and associate the rule with it.
        $updateOwnEventsAndLocations = $auth->createPermission('updateOwnEventsAndLocations');
        $updateOwnEventsAndLocations->description = 'Update member to update own EventsAndLocations';
        $updateOwnEventsAndLocations->ruleName = $rule->name;
        $auth->add($updateOwnEventsAndLocations);

        // "updateOwnEventsAndLocations" will be used from "updateEventsAndLocations"
        $auth->addChild($updateOwnEventsAndLocations, $updateEventsAndLocations);


        // add the "updateOwnEventsAndLocations" permission and associate the rule with it.
        $deleteOwnEventsAndLocations = $auth->createPermission('deleteOwnEventsAndLocations');
        $deleteOwnEventsAndLocations->description = 'Update member to delete own EventsAndLocations';
        $deleteOwnEventsAndLocations->ruleName = $rule->name;
        $auth->add($deleteOwnEventsAndLocations);

        $auth->addChild($deleteOwnEventsAndLocations, $deleteEventsAndLocations);
        
        //---------- ROLES ----------//

        // add "member" role
        $member = $auth->createRole('member');
        $member->description = 'Registered users, members of this site';
        $auth->add($member);
        $auth->addChild($member, $createPlayer);
        $auth->addChild($member, $updateOwnPlayer);
        $auth->addChild($member, $deleteOwnPlayer);
        $auth->addChild($member, $updateOwnUser);
        $auth->addChild($member, $deleteOwnUser);

        // add "premium" role
        $premium = $auth->createRole('premium');
        $premium->description = 'Premium members. They have more permissions than normal members';
        $auth->add($premium);
        $auth->addChild($premium, $member);
        $auth->addChild($premium, $usePremiumContent);
        $auth->addChild($premium, $createOrganisation);
        $auth->addChild($premium, $updateOwnOrganisation);
        $auth->addChild($premium, $deleteOwnOrganisation);
        $auth->addChild($premium, $createTournament);
        $auth->addChild($premium, $updateOwnTournament);
        $auth->addChild($premium, $deleteOwnTournament);

        // add "support" role
        // support can do everything that member and premium can, plus you can add him more powers
        $support = $auth->createRole('support');
        $support->description = 'Support staff';
        $auth->add($support); 
        $auth->addChild($support, $premium);
        $auth->addChild($support, $member);    

        // add "editor" role and give this role: 
        // createArticle, updateOwnArticle and adminArticle permissions, plus he can do everything that support role can do.
        $editor = $auth->createRole('editor');
        $editor->description = 'Editor of this application';
        $auth->add($editor);
        $auth->addChild($editor, $support);
        $auth->addChild($editor, $createArticle);
        $auth->addChild($editor, $adminArticle);
        $auth->addChild($editor, $updateOwnArticle);
        $auth->addChild($editor, $deleteOwnArticle);
        $auth->addChild($editor, $createGallery);
        $auth->addChild($editor, $adminGallery);
        $auth->addChild($editor, $updateOwnGallery);
        $auth->addChild($editor, $deleteOwnGallery);
        $auth->addChild($editor, $createEventsAndLocations);
        $auth->addChild($editor, $adminEventsAndLocations);
        $auth->addChild($editor, $updateOwnEventsAndLocations);
        $auth->addChild($editor, $deleteOwnEventsAndLocations);



        // add "admin" role and give this role: 
        // manageUsers, updateArticle adn deleteArticle permissions, plus he can do everything that editor role can do.
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator of this application';
        $auth->add($admin);
        $auth->addChild($admin, $editor);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $updateArticle);
        $auth->addChild($admin, $deleteArticle);
        $auth->addChild($admin, $updateGallery);
        $auth->addChild($admin, $deleteGallery);
        $auth->addChild($admin, $updatePlayer);
        $auth->addChild($admin, $deletePlayer);
        $auth->addChild($admin, $adminPlayer);
        $auth->addChild($admin, $updateOrganisation);
        $auth->addChild($admin, $deleteOrganisation);
        $auth->addChild($editor, $adminOrganisation);
        $auth->addChild($admin, $updateEventsAndLocations);
        $auth->addChild($admin, $deleteEventsAndLocations);
         $auth->addChild($admin, $updateTournament);
        $auth->addChild($admin, $deleteTournament);
        $auth->addChild($editor, $adminTournament);

        // add "theCreator" role ( this is you :) )
        // You can do everything that admin can do plus more (if You decide so)
        $theCreator = $auth->createRole('theCreator');
        $theCreator->description = 'You!';
        $auth->add($theCreator); 
        $auth->addChild($theCreator, $admin);

        if ($auth) 
        {
            $this->stdout("\nRbac authorization data are installed successfully.\n", Console::FG_GREEN);
        }
    }
}