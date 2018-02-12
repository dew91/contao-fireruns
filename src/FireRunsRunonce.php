<?php
/* === FireRuns Contao Bundle ===
 *
 * Copyright (c) 2017-2018 Dominic Ernst
 * http://www.dominic-ernst.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FireRunsRunonce.php
 * - class for first run stuff after bundle installation
 * - prepared to handle database updates for future module updates
 */

/**
 * FireRuns modules configuration
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */

namespace dew91\FireRuns;

/**
 * FireRuns Runonce
 *
 * @author Dominic Ernst <dev@dominic-ernst.com>
 */
abstract class FireRunsRunonce
{
  /**
   * Run database migrations after module update
   *
   * @return void
   */
  public static function run()
  {
    // Not yet implemented, as this is the first version of this bundle.
    return;
  }
}
?>
