<?php
namespace backend\controllers;

use common\models\User;
use common\models\UserSearch;
use common\rbac\models\Role;
use frontend\models\Article;
use frontend\models\Events;
use frontend\models\Galleries;
use frontend\models\Halloffame;
use frontend\models\Location;
use frontend\models\Organisation;
use frontend\models\OrganisationHasUser;
use frontend\models\Player;
use frontend\models\Team;
use frontend\models\TeamMember;
use frontend\models\Videos;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BackendController
{
    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param  integer $id The user id.
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'create']);
        $role = new Role();

        if ($user->load(Yii::$app->request->post()) &&
            $role->load(Yii::$app->request->post()) &&
            Model::validateMultiple([$user, $role])
        ) {
            $user->setPassword($user->password);
            $user->generateAuthKey();

            if ($user->save()) {
                $role->user_id = $user->getId();
                $role->save();
            }

            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'user' => $user,
                'role' => $role,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  integer $id The user id.
     * @return string|\yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // get role
        $role = Role::findOne(['user_id' => $id]);
        $roleOld = Role::findOne(['user_id' => $id]);

        // get user details
        $user = $this->findModel($id);
        $userOld = $this->findModel($id);
        // only The Creator can update everyone`s roles
        // admin will not be able to update role of theCreator
        if (!Yii::$app->user->can('theCreator')) {
            if ($role->item_name === 'theCreator') {
                return $this->goHome();
            }
        }


        // load user data with role and validate them
        if ($user->load(Yii::$app->request->post()) &&
            $role->load(Yii::$app->request->post())
        ) {

            if (Model::validateMultiple([$user, $role])) {
                if (!Yii::$app->user->can('manageUsers')) {
                    if($userOld->status != $user->status || $roleOld->item_name != $role->item_name){
                        Yii::$app->session->setFlash('error', 'Sie können ihre Rolle nicht ändern!');
                    }
                    $role->item_name = $roleOld->item_name;
                    $user->status = $userOld->status;
                }
                // only if user entered new password we want to hash and save it
                if ($user->password) {
                    $user->setPassword($user->password);
                }

                // if admin is activating user manually we want to remove account activation token
                if ($user->status == User::STATUS_ACTIVE && $user->account_activation_token != null) {
                    $user->removeAccountActivationToken();
                }

                $user->save(false);
                $role->save(false);

                return $this->redirect(['view', 'id' => $user->id]);
            }
        } else {
            return $this->render('update', [
                'user' => $user,
                'role' => $role,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  integer $id The user id.
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->id == $id) {
            Yii::$app->user->logout();
        }

        $model = $this->findModel($id);

        // delete this user's role from auth_assignment table
        if ($role = Role::find()->where(['user_id' => $id])->one()) {
            $role->delete();
        }
        if ($hallOfFameMembers = Halloffame::find()->where(['user_id' => $id])->all()) {
            foreach ($hallOfFameMembers as $member) {
                $member->delete();
            }
        }
        if ($players = Player::find()->where(['user_id' => $id])->all()) {
            foreach ($players as $player) {
                if($teamMember = TeamMember::find()->where(['player_id' => $player->id])->all()){
                    foreach ($teamMember as $member){
                        $member->delete();
                    }
                }
                if($hallOfFameMembers = Halloffame::find()->where(['player_id' => $player->id])->all()){
                    foreach ($hallOfFameMembers as $member){
                        $member->player_id = null;
                        $member->save();
                    }
                }
                $player->delete();
            }
        }
        if ($articles = Article::find()->where(['user_id' => $id])->all()) {
            foreach ($articles as $article) {
                $article->delete();
            }
        }
        if ($galleries = Galleries::find()->where(['user_id' => $id])->all()) {
            foreach ($galleries as $gallery) {
                $gallery->delete();
            }
        }
        if ($videos = Videos::find()->where(['user_id' => $id])->all()) {
            foreach ($videos as $video) {
                $video->delete();
            }
        }
        if ($teams = Team::find()->where(['user_id' => $id])->all()) {
            foreach ($teams as $team) {
                $team->delete();
            }
        }
        if ($organisationUsers = OrganisationHasUser::find()->where(['user_id' => $id])->all()) {
            foreach ($organisationUsers as $user) {
                $user->delete();
            }
        }
        if ($organisations = Organisation::find()->where(['user_id' => $id])->all()) {
            foreach ($organisations as $organisation) {
                $organisation->delete();
            }
        }
        if ($locations = Location::find()->where(['user_id' => $id])->all()) {
            foreach ($locations as $location) {
                $location->delete();
            }
        }
        if ($events = Events::find()->where(['user_id' => $id])->all()) {
            foreach ($events as $event) {
                $event->delete();
            }
        }

        $model->delete();

        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer $id The user id.
     * @return User The loaded model.
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
