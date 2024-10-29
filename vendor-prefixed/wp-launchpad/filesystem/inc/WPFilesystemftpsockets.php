<?php
/**
 * @license proprietary
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFilesystem;
use WP_Filesystem_ftpsockets;

class WPFilesystemftpsockets extends FilesystemBase
{

    public function __construct( $opt = '' )
    {
        parent::__construct();
        require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-ftpsockets.php';
        $this->filesystem = new WP_Filesystem_ftpsockets($opt);
    }
}
