<?php

/*
 * This file is part of PHPExifTool.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPExiftool\Driver\Tag\Matroska;

use JMS\Serializer\Annotation\ExclusionPolicy;
use PHPExiftool\Driver\AbstractTag;

/**
 * @ExclusionPolicy("all")
 */
class EditionFlagDefault extends AbstractTag
{

    protected $Id = 1499;

    protected $Name = 'EditionFlagDefault';

    protected $FullName = 'Matroska::Main';

    protected $GroupName = 'Matroska';

    protected $g0 = 'Matroska';

    protected $g1 = 'Matroska';

    protected $g2 = 'Video';

    protected $Type = 'unsigned';

    protected $Writable = false;

    protected $Description = 'Edition Flag Default';

}
