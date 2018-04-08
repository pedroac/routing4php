<?php

use pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator;
use pedroac\routing\PathRouter\PatternRouter;
use PHPUnit\Framework\TestCase;

/**
 * PlaceHoldersTranslator class tests.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
class PlaceHoldersTranslatorTest extends TestCase
{
    /**
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::__construct
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::toRegex
     */
    public function testToRegexSimple ()
    {
        $this->assertEquals(
            '~^users$~',
            (new PlaceHoldersTranslator)
                ->toRegex('users')
        );
        $this->assertEquals(
            '~^\\~users$~',
            (new PlaceHoldersTranslator)
                ->toRegex('~users')
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::__construct
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::toRegex
     */
    public function testToRegexDefaultPlaceHolders ()
    {
        $this->assertEquals(
            '~^(?P<user_id>.*)$~',
            (new PlaceHoldersTranslator)
                ->toRegex('<user_id>')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>.*)$~',
            (new PlaceHoldersTranslator)
                ->toRegex('users/<user_id>')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>[^/]*)/photos/(?P<photo_id>.*)$~',
            (new PlaceHoldersTranslator)
                ->toRegex('users/<user_id>/photos/<photo_id>')
        );
        $this->assertEquals(
            '~^date/(?P<year>[^\-]*)\-(?P<month>[^\-]*)\-(?P<day>.*)$~',
            (new PlaceHoldersTranslator)
                ->toRegex('date/<year>-<month>-<day>')
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::__construct
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::toRegex
     */
    public function testToRegexCustomPlaceHolders ()
    {
        $this->assertEquals(
            '~^users$~',
            (new PlaceHoldersTranslator(':', ''))
                ->toRegex('users')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>.*)$~',
            (new PlaceHoldersTranslator(':', ''))
                ->toRegex('users/:user_id')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>[^/]*)/photos/(?P<photo_id>.*)$~',
            (new PlaceHoldersTranslator(':', ''))
                ->toRegex('users/:user_id/photos/:photo_id')
        );
    }

    /**
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::__construct
     * @covers pedroac\routing\PathRouter\ToRegex\PlaceHoldersTranslator::toRegex
     */
    public function testToRegexLongDelimiters()
    {
        $this->assertEquals(
            '~^users$~',
            (new PlaceHoldersTranslator('|-', '-|'))
                ->toRegex('users')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>.*)$~',
            (new PlaceHoldersTranslator('|-', '-|'))
                ->toRegex('users/|-user_id-|')
        );
        $this->assertEquals(
            '~^users/(?P<user_id>[^/]*)/photos/(?P<photo_id>.*)$~',
            (new PlaceHoldersTranslator('|-', '-|'))
                ->toRegex('users/|-user_id-|/photos/|-photo_id-|')
        );
    }
}