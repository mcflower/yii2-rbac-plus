<?php

namespace mcflower\rbacplus\models;

use Yii;
use yii\rbac\Item;

/**
 * @author Ilya Zelenskiy <elias-green@yandex.ru>
 * @since 1.0.0
 */
class RoleSearch extends AuthItemSearch {

    public function __construct($config = array()) {
        parent::__construct($item = null, $config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Role name');
        $labels['permissions'] = Yii::t('rbac', 'Permissions');
        return $labels;
    }

    /**
     * @inheritdoc
     */
    protected function getType() {
        return Item::TYPE_ROLE;
    }

}
