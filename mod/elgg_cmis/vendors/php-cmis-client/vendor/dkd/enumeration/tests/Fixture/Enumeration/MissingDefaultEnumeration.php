<?php
namespace Dkd\Enumeration\Tests\Fixture\Enumeration;

/**
 * This file is part of the dkd\enumeration package.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * This is an enumeration without a default value so it must be called with a value
 */
class MissingDefaultEnumeration extends AbstractEnumerationMock
{
    const FOO = 1;
}
