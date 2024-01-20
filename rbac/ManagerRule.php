<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class ManagerRule extends Rule
{
    public $name = 'manager';

    public function execute($user, $item, $params)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($user);

        if (in_array($item,$roles)) {
            return true;
        }

        foreach ($roles as $role) {
            $children = $authManager->getChildren($role->name);
            if (in_array($item, $children)) {
                return true;
            }
        }
        return false;
    }
}