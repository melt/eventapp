<?php namespace nmvc\userx;

class GroupModel extends GroupModel_app_overrideable {
    const CONTEXT_GUEST = 0;
    const CONTEXT_MEMBER = 1;
    const CONTEXT_AMBASSADOR = 2;
    const CONTEXT_ADMIN = 3;
    const CONTEXT_SUPERADMIN = 4; // Reserved for later

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
            case GroupModel::CONTEXT_AMBASSADOR:
                $name = "Ambassador";
                break;
            case GroupModel::CONTEXT_ADMIN:
            case GroupModel::CONTEXT_SUPERADMIN:
                $name = "Administrator";
                break;
            
        }
        return $name . " (" . $this->context. ")";
    }
}
