<?php namespace nmvc\userx;
/* Auto generated empty class override. */


class GroupModel extends GroupModel_app_overrideable {
    const CONTEXT_SUPERADMIN = 1;
    const CONTEXT_MANAGER = 2;
    const CONTEXT_USER = 3;

    public $context = 'core\IntegerType';

    public static function getStandardGroup($context) {
        $group = GroupModel::select()->where("context")->is($context)->first();
        if ($group === null) {
            $group = new GroupModel();
            $group->context = $context;
            $group->store();
        }
        return $group;
    }
}
