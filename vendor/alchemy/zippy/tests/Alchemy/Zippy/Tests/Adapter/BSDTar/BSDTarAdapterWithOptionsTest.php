<?php

namespace Alchemy\Zippy\Tests\Adapter\BSDTar;

use Alchemy\Zippy\Tests\TestCase;
use Alchemy\Zippy\Parser\ParserFactory;

abstract class BSDTarAdapterWithOptionsTest extends TestCase
{
    protected static $tarFile;

    /**
     * @var AbstractBSDTarAdapter
     */
    protected $adapter;

    public static function setUpBeforeClass()
    {
        $classname = static::getAdapterClassName();
        self::$tarFile = sprintf('%s/%s.tar', self::getResourcesPath(), $classname::getName());

        if (file_exists(self::$tarFile)) {
            unlink(self::$tarFile);
        }
    }

    public static function tearDownAfterClass()
    {
        if (file_exists(self::$tarFile)) {
            unlink(self::$tarFile);
        }
    }

    public function setUp()
    {
        $classname = static::getAdapterClassName();

        $inflator = $this->getMockBuilder('Alchemy\Zippy\ProcessBuilder\ProcessBuilderFactory')
                ->disableOriginalConstructor()
                ->setMethods(array('useBinary'))
                ->getMock();

        $outputParser = ParserFactory::create($classname::getName());

        $manager = $this->getResourceManagerMock(__DIR__);

        $this->adapter = new $classname($outputParser, $manager, $inflator);
    }

    public function testCreateNoFiles()
    {
        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--create'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo('-'))
            ->will($this->returnSelf());

        $nullFile = defined('PHP_WINDOWS_VERSION_BUILD') ? 'NUL' : '/dev/null';

        $mockProcessBuilder
            ->expects($this->at(3))
            ->method('add')
            ->with($this->equalTo(sprintf('--files-from %s', $nullFile)))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(4))
            ->method('add')
            ->with($this->equalTo((sprintf('> %s', self::$tarFile))))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->create(self::$tarFile, array());
    }

    public function testCreate()
    {
        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--create'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo(sprintf('--file=%s', self::$tarFile)))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(3))
            ->method('setWorkingDirectory')
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(4))
            ->method('add')
            ->with($this->equalTo('lalalalala'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $classname = static::getAdapterClassName();
        $outputParser = ParserFactory::create($classname::getName());
        $manager = $this->getResourceManagerMock(__DIR__, array('lalalalala'));

        $this->adapter = new $classname($outputParser, $manager, $this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->create(self::$tarFile, array(__FILE__));

        return self::$tarFile;
    }

    /**
     * @depends testCreate
     */
    public function testOpen($tarFile)
    {
        $archive = $this->adapter->open($tarFile);
        $this->assertInstanceOf('Alchemy\Zippy\Archive\ArchiveInterface', $archive);

        return $archive;
    }

    public function testListMembers()
    {
        $resource = $this->getResource(self::$tarFile);

        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--list'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo('-v'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo(sprintf('--file=%s', $resource->getResource())))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(3))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->listMembers($resource);
    }

    public function testAddFile()
    {
        $resource = $this->getResource(self::$tarFile);

        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--delete'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo('--append'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo(sprintf('--file=%s', $resource->getResource())))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->add($resource, array(__DIR__ . '/../TestCase.php'));
    }

    public function testgetVersion()
    {
        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--version'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->getInflatorVersion();
    }

    public function testExtract()
    {
        $resource = $this->getResource(self::$tarFile);

        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--extract'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo(sprintf('--file=%s', $resource->getResource())))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $dir = $this->adapter->extract($resource);
        $pathinfo = pathinfo(self::$tarFile);
        $this->assertEquals($pathinfo['dirname'], $dir->getPath());
    }

    public function testExtractWithExtractDirPrecised()
    {
        $resource = $this->getResource(self::$tarFile);

        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--extract'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo('--file=' . $resource->getResource()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(3))
            ->method('add')
            ->with($this->equalTo('--directory'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(4))
            ->method('add')
            ->with($this->equalTo(__DIR__))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(5))
            ->method('add')
            ->with($this->equalTo(__FILE__))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->extractMembers($resource, array(__FILE__), __DIR__);
    }

    public function testRemoveMembers()
    {
        $resource = $this->getResource(self::$tarFile);

        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->at(0))
            ->method('add')
            ->with($this->equalTo('--delete'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(1))
            ->method('add')
            ->with($this->equalTo('--file=' . $resource->getResource()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(2))
            ->method('add')
            ->with($this->equalTo($this->getOptions()))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(3))
            ->method('add')
            ->with($this->equalTo(__DIR__ . '/../TestCase.php'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->at(4))
            ->method('add')
            ->with($this->equalTo('path-to-file'))
            ->will($this->returnSelf());

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->getSuccessFullMockProcess()));

        $archiveFileMock = $this->getMock('Alchemy\Zippy\Archive\MemberInterface');
        $archiveFileMock
            ->expects($this->any())
            ->method('getLocation')
            ->will($this->returnValue('path-to-file'));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->adapter->remove($resource, array(
            __DIR__ . '/../TestCase.php',
            $archiveFileMock
        ));
    }

    public function testThatGNUTarIsNotMarkedAsSupported()
    {
        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnSelf());

        $process = $this->getSuccessFullMockProcess();

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue('tar (GNU tar) 1.17
Copyright (C) 2007 Free Software Foundation, Inc.
License GPLv2+: GNU GPL version 2 or later <http://gnu.org/licenses/gpl.html>
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.

Modified to support extended attributes.
Written by John Gilmore and Jay Fenlason.'));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->assertFalse($this->adapter->isSupported());
    }

    public function testThatBsdTarIsMarkedAsSupported()
    {
        $mockProcessBuilder = $this->getMock('Symfony\Component\Process\ProcessBuilder');

        $mockProcessBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnSelf());

        $process = $this->getSuccessFullMockProcess();

        $mockProcessBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($process));

        $process
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue('bsdtar 2.8.3 - libarchive 2.8.3'));

        $this->adapter->setInflator($this->getZippyMockBuilder($mockProcessBuilder));

        $this->assertTrue($this->adapter->isSupported());
    }

    public function testGetName()
    {
        $classname = static::getAdapterClassName();
        $this->assertEquals('bsd-tar', $classname::getName());
    }

    public function testGetDefaultInflatorBinaryName()
    {
        $classname = static::getAdapterClassName();
        $this->assertEquals(array('bsdtar', 'tar'), $classname::getDefaultInflatorBinaryName());
    }

    public function testGetDefaultDeflatorBinaryName()
    {
        $classname = static::getAdapterClassName();
        $this->assertEquals(array('bsdtar', 'tar'), $classname::getDefaultDeflatorBinaryName());
    }

    abstract protected function getOptions();

    protected static function getAdapterClassName()
    {
        $this->fail(sprintf('Method %s should be implemented', __METHOD__));
    }

    private function getSuccessFullMockProcess()
    {
        $mockProcess = $this
            ->getMockBuilder('Symfony\Component\Process\Process')
            ->disableOriginalConstructor()
            ->getMock();

        $mockProcess
            ->expects($this->once())
            ->method('run');

        $mockProcess
            ->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(true));

        return $mockProcess;
    }

    private function getZippyMockBuilder($mockedProcessBuilder)
    {
        $mockBuilder = $this->getMock('Alchemy\Zippy\ProcessBuilder\ProcessBuilderFactoryInterface');

        $mockBuilder
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockedProcessBuilder));

        return $mockBuilder;
    }
}
