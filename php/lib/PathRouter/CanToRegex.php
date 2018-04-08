<?php

namespace pedroac\routing\PathRouter;

/**
 * Interface to provide the ability of translating a pattern to regex.
 * 
 * @author Pedro Amaral Couto
 * @license MIT
 */
interface CanToRegex
{
    /**
     * Translate a pattern to regex.
     *
     * @param string $pattern The pattern that should be translated.
     * @return string The regex string.
     */
    public function toRegex(string $pattern): string;
}