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
 * This is an invalid enumeration because the constant values are not unique
 */
class DuplicateConstantValueEnumeration extends AbstractEnumerationMock
{
    const FOO = 1;
    const BAR = 1;
}
