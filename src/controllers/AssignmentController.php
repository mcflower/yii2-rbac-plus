<?php

namespace mcflower\rbacplus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use mcflower\rbacplus\Module;
use mcflower\rbacplus\models\AssignmentSearch;
use mcflower\rbacplus\models\AssignmentForm;

/**
 * AssignmentController is controller for manager user assignment
 *
 * @author Ilya Zelenskiy <elias-green@yandex.ru>
 * @since 1.0.0
 */
class AssignmentController extends Controller {

    /**
     * The current rbac module
     * @var Module $rbacModule
     */
    protected $rbacModule;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->rbacModule = Yii::$app->getModule('rbac');
    }
    
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('sys_admin') && !\Yii::$app->user->can('root')) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show list of user for assignment
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AssignmentSearch;
        $dataProvider = $searchModel->search();
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'idField' => $this->rbacModule->userModelIdField,
                    'usernameField' => $this->rbacModule->userModelLoginField,
        ]);
    }

    /**
     * Assignment roles to user
     * @param mixed $id The user id
     * @return mixed
     */
    public function actionAssignment($id) {
        $model = call_user_func($this->rbacModule->userModelClassName . '::findOne', $id);
        $formModel = new AssignmentForm($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $formModel->load(Yii::$app->request->post());
                $formModel->save();
            }
            return [
                'title' => $model->{$this->rbacModule->userModelLoginField},
                'forceReload' => "true",
                'content' => $this->renderPartial('assignment', [
                    'model' => $model,
                    'formModel' => $formModel,
                ]),
                'footer' => Html::button(Yii::t('rbac', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::button(Yii::t('rbac', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else {
            return $this->render('assignment', [
                        'model' => $model,
                        'formModel' => $formModel,
            ]);
        }
    }

}
