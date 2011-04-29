<?php namespace nmvc;

interface AjaxListable {
    /**
     * Returns an array of actions (method names) mapped to their
     * title and optionally array of title and icon picture that
     * should be listed.
     * @param string $interface_name
     * @return array
     */
    public function getAjaxListActions($interface_name);

    /**
     * Returns an array of data cells that is used to display this instance.
     * @param string $interface_name
     * @return array
     */
    public function getAjaxListCells($interface_name);
}