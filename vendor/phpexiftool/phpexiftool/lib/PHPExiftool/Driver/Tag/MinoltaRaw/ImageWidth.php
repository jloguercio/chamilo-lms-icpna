<?php

/*
 * This file is part of PHPExifTool.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPExiftool\Driver\Tag\MinoltaRaw;

use JMS\Serializer\Annotation\ExclusionPolicy;
use PHPExiftool\Driver\AbstractTag;

/**
 * @ExclusionPolicy("all")
 */
class ImageWidth extends AbstractTag
{

    protected $Id = 14;

    protected $Name = 'ImageWidth';

    protected $FullName = 'MinoltaRaw::PRD';

    protected $GroupName = 'MinoltaRaw';

    protected $g0 = 'MakerNotes';

    protected $g1 = 'MinoltaRaw';

    protected $g2 = 'Camera';

    protected $Type = 'int16u';

    protected $Writable = true;

    protected $Description = 'Image Width';

    protected $flag_Permanent = true;

}
