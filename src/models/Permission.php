<?php

namespace mcflower\rbacplus\models;

use Yii;
use yii\rbac\Item;

/**
 * Description of Permistion
 *
 * @author Ilya Zelenskiy <elias-green@yandex.ru>
 * @since 1.0.0
 */
class Permission extends AuthItem {

    protected function getType() {
        return Item::TYPE_PERMISSION;
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Permission name');
        return $labels;
    }

    public static function find($name) {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getPermission($name);
        return new self($item);
    }

}
