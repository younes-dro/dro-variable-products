<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DRO_Notices {

    public $dro_notices_ags;
    public $dro_notices_cpt;

    public function __construct(array $dro_notices_args) {

        $this->dro_notices_ags = $dro_notices_args;

        add_action('init', [$this, 'create_menu']);

    }

    public function create_menu() {

        $this->dro_notices_cpt = register_post_type('dro_notices', $this->dro_notices_ags);
    }

}
