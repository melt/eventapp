<?php namespace nmvc;

class AjaxController extends AppController {
    public $layout = "/ajax/ajax_layout";

    public static function getSecureAjaxLink(core\InvokeData $invoke) {
        $data = array($invoke, id(userx\get_user()));
        return url("/ajax/callback/" . string\simple_crypt(\gzdeflate(\serialize($data), 9)));
    }

    public static function setDirectTaskProcessorHeader($title, $method) {
        $arguments = \func_get_args();
        unset($arguments[0]);
        unset($arguments[1]);
        $invoke_data = new core\InvokeData('nmvc\AjaxController', '_execute_task', array($method, \array_values($arguments)));
        $url = self::getSecureAjaxLink($invoke_data);
        \header("X-Task-Processor-Url: $url");
        \header("X-Task-Processor-Title: " . \iconv("UTF-8", "ISO-8859-1", $title));
    }

    public function _execute_task($method, $arguments) {
        \ignore_user_abort(true);
        \set_time_limit(0);
        $direct_tasks_processor = DirectTasksProcessor::getDefault();
        \call_user_func_array(array($direct_tasks_processor, $method), $arguments);
        exit;
    }

    public function callback($secret) {
        $data = string\simple_decrypt($secret);
        if ($data === false)
            request\show_404();
        list($invoke, $userid) = \unserialize(\gzinflate($data));
        if ($userid !== id(userx\get_user()))
            request\show_xyz(403);
        $controller = $invoke->getControllerClass();
        // Forwarding invoke.
        if (!$controller::invoke($invoke->getActionName(), $invoke->getArguments(), true))
            \trigger_error("Invoke failed: " . \print_r($invoke, true), \E_USER_ERROR);
        exit;
    }

    public function app_banner($id) {
        $app = DirectInstallSourceModel::selectByID($id);
        if ($app === null)
            request\show_404();
        request\redirect($app->type("logo")->getUrl(450, 80));
    }

    public function _print_instances_list($selection, $title = "List of things", $icon = "/static/img/silk/application_view_columns.png", $interface_name = "default", $return_url = null) {
        if ($selection instanceof db\SelectQuery)
            $instances = $selection->all();
        else if (\is_array($selection) && \is_callable($selection))
            $instances = \call_user_func($selection);
        else
            trigger_error("Invalid selection.", \E_USER_ERROR);
        if (count($instances) == 0) {
            $table_data = "";
        } else {
            $row_heading = array();
            $rows = array();
            $action_rows = array();
            $got_actions = false;
            $data_maxwidth = $action_maxwidth = 0;
            foreach ($instances as $instance) {
                $row = array();
                if (!($instance instanceof AjaxListable))
                    trigger_error("Instance is not a AjaxListable.", \E_USER_ERROR);
                $cells = $instance->getAjaxListCells($interface_name);
                if (!\is_array($cells))
                    $cells = array();
                // Read out headings.
                foreach ($cells as $heading => &$cell) {
                    if (isset($row_heading[$heading]))
                        continue;
                    $row_heading[$heading] = \is_string($heading)? $heading: null;
                }
                $row["data"] = $cells;
                $actions = $instance->getAjaxListActions($interface_name);
                if (!\is_array($actions))
                    $actions = array();
                //$action_maxwidth = \max($action_maxwidth, count($actions));
                foreach ($actions as $action => &$action_data) {
                    if (!\is_array($action_data)) {
                        $button_data = array("title" => $action_data);
                    } else {
                        $button_data = array(
                            "title" => @$action_data[0],
                            "icon" => (isset($action_data["icon"])? $action_data["icon"]: null),
                            "confirm_msg" => (isset($action_data["confirm"])? $action_data["confirm"]: null),
                        );
                        if (isset($action_data["dangerous_superadmin_feature"])
                        && $action_data["dangerous_superadmin_feature"])
                            $button_data["class"] = "dangerous_superadmin_feature";
                        if (isset($action_data["class"]))
                            $button_data["class"] = @$button_data["class"] . " " . $action_data["class"];
                    }
                    if ($action[0] == "/")
                        $url = url($action);
                    else if ($action[0] == "@")
                        $url = qmi\get_action_link($instance, \substr($action, 1), $return_url);
                    else
                        $url = $action;
                    $button_data["url"] = $url;
                    $view_path = "/ajax/ajax_list_button";
                    $action_data = View::render($view_path, $button_data, true, false);
                }
                if (\count($actions) > 0)
                    $got_actions = true;
                $row["actions"] = \implode("", $actions);
                $rows[] = $row;
            }
            $table_data= "";
            $table_data .= "<tr>";
            foreach ($row_heading as $id => $heading)
                $table_data .= "<th>" . escape($heading) . "</th>";
            if ($got_actions)
                $table_data .= "<th></th>";
            $table_data .= "</tr>";
            foreach ($rows as $row) {
                $table_data .= "<tr>";
                foreach ($row_heading as $id => $heading)
                    $table_data .= "<td>" . @$row["data"][$id] . "</td>";
                if ($got_actions)
                    $table_data .= "<td class=\"list_action\">" . $row["actions"] . "</td>";
                $table_data .= "</tr>";
            }
        }
        $this->title = $title;
        $this->icon = $icon;
        $this->table_data = $table_data;
        $this->refresh_url = $this->getSecureAjaxLink(new core\InvokeData(__CLASS__, "_print_instances_list", \func_get_args()));
        return "/ajax/ajax_list";
    }
}