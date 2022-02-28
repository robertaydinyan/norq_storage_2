<?php

namespace app\commands;

use app\rbac\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager  = Yii::$app->authManager;
        $authManager ->removeAll();

        // Create roles
        $guest  = $authManager->createRole('guest');
        $admin  = $authManager->createRole('admin');
        $manager  = $authManager->createRole('manager');
        $operator  = $authManager->createRole('operator');
        $terminal  = $authManager->createRole('terminal');
        $technician  = $authManager->createRole('technician');

        // Create simple, based on action{$NAME} permissions
//        $login  = $authManager->createPermission('login');
//        $logout = $authManager->createPermission('logout');
//        $error  = $authManager->createPermission('error');
//        $signUp = $authManager->createPermission('sign-up');
//        $index  = $authManager->createPermission('index');
//        $view   = $authManager->createPermission('view');
//        $update = $authManager->createPermission('update');
//        $delete = $authManager->createPermission('delete');

        // Add permissions in Yii::$app->authManager
//        $authManager->add($login);
//        $authManager->add($logout);
//        $authManager->add($error);
//        $authManager->add($signUp);
//        $authManager->add($index);
//        $authManager->add($view);
//        $authManager->add($update);
//        $authManager->add($delete);

        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
        $manager->ruleName  = $userGroupRule->name;
        $operator->ruleName  = $userGroupRule->name;
        $terminal->ruleName  = $userGroupRule->name;
        $technician->ruleName  = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($admin);
        $authManager->add($manager);
        $authManager->add($operator);
        $authManager->add($terminal);
        $authManager->add($technician);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
//        $authManager->addChild($guest, $login);
//        $authManager->addChild($guest, $error);

        // Manager
//        $authManager->addChild($manager, $index);
//        $authManager->addChild($manager, $view);
//        $authManager->addChild($manager, $update);
//        $authManager->addChild($manager, $delete);

        // Admin
//        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $manager);
        $authManager->addChild($admin, $operator);
        $authManager->addChild($admin, $terminal);

        // Module crud permissions

        // Deal
        $createDeal = $authManager->createPermission('createDeal');
        $createDeal->description = 'Ստեղծել գործարք';
        $updateDeal = $authManager->createPermission('updateDeal');
        $updateDeal->description = 'Թարմացնել գործարք';
        $viewDeal = $authManager->createPermission('viewDeal');
        $viewDeal->description = 'Տեսնել գործարք';
        $deleteDeal = $authManager->createPermission('deleteDeal');
        $deleteDeal->description = 'Ջնջել գործարք';
        $sendToPrintCashRegisterReceipt = $authManager->createPermission('sendToPrintCashRegisterReceipt');
        $sendToPrintCashRegisterReceipt->description = 'ՀԴՄ';
        $printCashRegisterReceipt = $authManager->createPermission('printCashRegisterReceipt');
        $printCashRegisterReceipt->description = 'Տպել ՀԴՄ կտրոն';
        $setPaymentDate = $authManager->createPermission('setPaymentDate');
        $setPaymentDate->description = 'Նշել վճարման անսաթիվ';

        // Payment log
        $changePayment = $authManager->createPermission('changePayment');
        $changePayment->description = 'Վճարի փոփոխում';
        $acceptPayment = $authManager->createPermission('acceptPayment');
        $acceptPayment->description = 'Վճարի ընդունում';
        $viewPayment = $authManager->createPermission('viewPayment');
        $viewPayment->description = 'Տեսնել վճարում';
        $viewAllPayment = $authManager->createPermission('seeAllPayments');
        $viewAllPayment->description = 'Տեսնել բոլոր վճարումները';

        // Task
        $createTask = $authManager->createPermission('createTask');
        $createTask->description = 'Ստեղծել առաջադրանք';
        $updateTask = $authManager->createPermission('updateTask');
        $updateTask->description = 'Թարմացնել առաջադրանք';
        $viewTask = $authManager->createPermission('viewTask');
        $viewTask->description = 'Տեսնել առաջադրանք';
        $deleteTask = $authManager->createPermission('deleteTask');
        $deleteTask->description = 'Ջնջել առաջադրանք';

        // CRM Company
        $createCompany = $authManager->createPermission('createCompany');
        $createCompany->description = 'Ստեղծել կազմակերպություն';
        $updateCompany = $authManager->createPermission('updateCompany');
        $updateCompany->description = 'Թարմացնել կազմակերպություն';
        $viewCompany = $authManager->createPermission('viewCompany');
        $viewCompany->description = 'Տեսնել կազմակերպություն';
        $deleteCompany = $authManager->createPermission('deleteCompany');
        $deleteCompany->description = 'Ջնջել կազմակերպություն';

        // CRM Contact
        $createContact = $authManager->createPermission('createContact');
        $createContact->description = 'Ստեղծել Ֆիզ․ անձ';
        $updateContact = $authManager->createPermission('updateContact');
        $updateContact->description = 'Թարմացնել Ֆիզ․ անձ';
        $viewContact = $authManager->createPermission('viewContact');
        $viewContact->description = 'Տեսնել Ֆիզ․ անձ';
        $deleteContact = $authManager->createPermission('deleteContact');
        $deleteContact->description = 'Ջնջել Ֆիզ․ անձ';

        $authManager->add($createDeal);
        $authManager->add($updateDeal);
        $authManager->add($viewDeal);
        $authManager->add($deleteDeal);
        $authManager->add($sendToPrintCashRegisterReceipt);
        $authManager->add($printCashRegisterReceipt);
        $authManager->add($setPaymentDate);

        $authManager->add($changePayment);
        $authManager->add($acceptPayment);
        $authManager->add($viewPayment);
        $authManager->add($viewAllPayment);

        $authManager->add($createTask);
        $authManager->add($updateTask);
        $authManager->add($viewTask);
        $authManager->add($deleteTask);

        $authManager->add($createCompany);
        $authManager->add($updateCompany);
        $authManager->add($viewCompany);
        $authManager->add($deleteCompany);

        $authManager->add($createContact);
        $authManager->add($updateContact);
        $authManager->add($viewContact);
        $authManager->add($deleteContact);

        $authManager->addChild($admin, $createDeal);
        $authManager->addChild($admin, $updateDeal);
        $authManager->addChild($admin, $viewDeal);
        $authManager->addChild($admin, $deleteDeal);
        $authManager->addChild($admin, $sendToPrintCashRegisterReceipt);
        $authManager->addChild($admin, $printCashRegisterReceipt);
        $authManager->addChild($admin, $setPaymentDate);
        $authManager->addChild($admin, $changePayment);
        $authManager->addChild($admin, $acceptPayment);
        $authManager->addChild($admin, $viewPayment);
        $authManager->addChild($admin, $viewAllPayment);
        $authManager->addChild($admin, $createTask);
        $authManager->addChild($admin, $updateTask);
        $authManager->addChild($admin, $viewTask);
        $authManager->addChild($admin, $deleteTask);
        $authManager->addChild($admin, $createCompany);
        $authManager->addChild($admin, $updateCompany);
        $authManager->addChild($admin, $viewCompany);
        $authManager->addChild($admin, $deleteCompany);
        $authManager->addChild($admin, $createContact);
        $authManager->addChild($admin, $updateContact);
        $authManager->addChild($admin, $viewContact);
        $authManager->addChild($admin, $deleteContact);
    }
}