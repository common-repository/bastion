<?php
/**
 * @license proprietary
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFilesystem;

use stdClass;
use WP_Filesystem_Base;
use WP_Filesystem_Direct;

class WPFilesystemDirect extends FilesystemBase
{
   public function __construct(StdClass $configs = null)
   {
       parent::__construct();
       require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
       $this->filesystem = new WP_Filesystem_Direct( $configs ?: new StdClass() );
   }
}
