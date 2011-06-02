<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_rvsp_page() {
        $this->doValidate();
        $this->doStore();
        //$instances = $this->getInstances();
        //$sr = $instances['nmvc\EventInviteeModel'][0];
        \nmvc\request\redirect(url("/admin/thanks", array("rvsp" => null)));
    }

    public function ic_add_event() {
        \nmvc\request\redirect("/");
    }



    public function ic_user_profile() {
                \nmvc\request\redirect("/");

    }

}
