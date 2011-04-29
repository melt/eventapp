<?php namespace nmvc; ?>
<?php AjaxController::invoke("_print_instances_list", array(
userx\UserModel::select(),
_("Users"),
"user_list",
), true); ?>