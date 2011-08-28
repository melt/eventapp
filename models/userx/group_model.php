<?php namespace melt\userx;
/* Auto generated empty class override. */


class GroupModel extends GroupModel_app_overrideable {
    const CONTEXT_GUEST = 0; // Allow edit profile
    const CONTEXT_MEMBER = 5; // Allow edit profile, allow create/edit events, allow see members
    const CONTEXT_ADMIN = 9; // Allow all

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

    public function __toString(){
        switch ($this->context) {
            case GroupModel::CONTEXT_GUEST:
                $name = "Guest";
                break;
            case GroupModel::CONTEXT_MEMBER:
                $name = "Member";
                break;
            case GroupModel::CONTEXT_ADMIN:
                $name = "Administrator";
                break;
        }
        return $name . " (" . $this->context. ")";
    }	
}
