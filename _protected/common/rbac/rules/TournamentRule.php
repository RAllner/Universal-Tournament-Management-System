<?php
namespace common\rbac\rules;

use frontend\models\OrganisationHasUser;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class TournamentRule extends Rule
{
    public $name = 'isTournamentOwner';

    /**
     * @param  string|integer $user   The user ID.
     * @param  Item           $item   The role or permission that this rule is associated with
     * @param  array          $params Parameters passed to ManagerInterface::checkAccess().
     * @return boolean                A value indicating whether the rule permits the role or 
     *                                permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if(isset($params['model'])){
            if($params['model']->isUserOwner()){
                return $params['model']->createdBy->id == $user;
            } else {
                return OrganisationHasUser::find()->where(['organisation_id' => $params['model']->createdBy->id, 'user_id' => $user])->exists();
            }
        } else {
            return false;
        }
    }
}