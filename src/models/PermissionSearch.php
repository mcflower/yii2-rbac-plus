<?php

namespace mcflower\rbacplus\models;

use Yii;
use yii\rbac\Item;

/**
 * @author Ilya Zelenskiy <elias-green@yandex.ru>
 * @since 1.0.0
 */
class PermissionSearch extends AuthItemSearch {

    public function __construct($config = array()) {
        parent::__construct($item = null, $config);
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Permission name');
        return $labels;
    }

    protected function getType() {
        return Item::TYPE_PERMISSION;
    }

}
