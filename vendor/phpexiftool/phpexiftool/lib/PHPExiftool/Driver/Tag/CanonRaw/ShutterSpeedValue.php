<?php

/*
 * This file is part of PHPExifTool.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPExiftool\Driver\Tag\CanonRaw;

use JMS\Serializer\Annotation\ExclusionPolicy;
use PHPExiftool\Driver\AbstractTag;

/**
 * @ExclusionPolicy("all")
 */
class ShutterSpeedValue extends AbstractTag
{

    protected $Id = 1;

    protected $Name = 'ShutterSpeedValue';

    protected $FullName = 'CanonRaw::ExposureInfo';

    protected $GroupName = 'CanonRaw';

    protected $g0 = 'MakerNotes';

    protected $g1 = 'CanonRaw';

    protected $g2 = 'Image';

    protected $Type = 'float';

    protected $Writable = true;

    protected $Description = 'Shutter Speed Value';

    protected $flag_Permanent = true;

}
