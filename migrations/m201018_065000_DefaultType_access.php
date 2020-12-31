<?php

use yii\db\Migration;

class m201018_065000_DefaultType_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_default-type_index",
            "description" => "app/default-type/index"
        ],
        "view" => [
            "name" => "app_default-type_view",
            "description" => "app/default-type/view"
        ],
        "create" => [
            "name" => "app_default-type_create",
            "description" => "app/default-type/create"
        ],
        "update" => [
            "name" => "app_default-type_update",
            "description" => "app/default-type/update"
        ],
        "delete" => [
            "name" => "app_default-type_delete",
            "description" => "app/default-type/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppDefaultTypeFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppDefaultTypeView" => [
            "index",
            "view"
        ],
        "AppDefaultTypeEdit" => [
            "update",
            "create",
            "delete"
        ]
    ];
    
    public function up()
    {
        
        $permisions = [];
        $auth = \Yii::$app->authManager;

        /**
         * create permisions for each controller action
         */
        foreach ($this->permisions as $action => $permission) {
            $permisions[$action] = $auth->createPermission($permission['name']);
            $permisions[$action]->description = $permission['description'];
            $auth->add($permisions[$action]);
        }

        /**
         *  create roles
         */
        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->add($role);

            /**
             *  to role assign permissions
             */
            foreach ($actions as $action) {
                $auth->addChild($role, $permisions[$action]);
            }
        }
    }

    public function down() {
        $auth = Yii::$app->authManager;

        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->remove($role);
        }

        foreach ($this->permisions as $permission) {
            $authItem = $auth->createPermission($permission['name']);
            $auth->remove($authItem);
        }
    }
}
