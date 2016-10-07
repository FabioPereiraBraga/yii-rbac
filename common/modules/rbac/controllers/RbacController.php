<?php

namespace common\modules\rbac\controllers;

use Yii;



class RbacController extends \yii\web\Controller
{
    /**
     * criar urls para validacao de acesso
     */
    public function actionCreatePermissao()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $index = $auth->createPermission('auth/post/index');
        $index->description = 'Create a post';
        $auth->add($index);

        // add "updatePost" permission
        $create= $auth->createPermission('auth/post/create');
        $create->description = 'Create post';
        $auth->add($create);

        $view = $auth->createPermission('auth/post/view');
        $view->description = 'View post';
        $auth->add($view);

        $update = $auth->createPermission('auth/post/update');
        $update->description = 'Update post';
        $auth->add($update);

        $delete = $auth->createPermission('auth/post/delete');
        $delete->description = 'Delete post';
        $auth->add($delete);


    }


    public function  actionCreateRole()
    {
        //Author -> index/create/view
        //Admin  -> {Author} and update/delete ->  ndex/create/view/update/delete

        $auth = Yii::$app->authManager;

        $index  = $auth->createPermission('auth/post/index');
        $create = $auth->createPermission('auth/post/create');
        $view   = $auth->createPermission('auth/post/view');

        $update = $auth->createPermission('auth/post/update');
        $delete = $auth->createPermission('auth/post/delete');


        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $index);
        $auth->addChild($author, $create);
        $auth->addChild($author, $view);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
    }


    public function actionAssigment()
    {
        $auth = Yii::$app->authManager;

        $author = $auth->createRole('author');
        $admin = $auth->createRole('admin');

        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }






}
