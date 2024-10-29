<?php
/**
 * @license proprietary
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFront;

use Bastion\Dependencies\LaunchpadBudAssets\Assets;

interface UseAssetsInterface
{
    /**
     * Set Assets.
     *
     * @param Assets $assets
     */
    public function set_assets(Assets $assets);
}
