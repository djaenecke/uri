<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2012 - 2013, The Lousson Project                        *
 *                                                                       *
 * All rights reserved.                                                  *
 *                                                                       *
 * Redistribution and use in source and binary forms, with or without    *
 * modification, are permitted provided that the following conditions    *
 * are met:                                                              *
 *                                                                       *
 * 1) Redistributions of source code must retain the above copyright     *
 *    notice, this list of conditions and the following disclaimer.      *
 * 2) Redistributions in binary form must reproduce the above copyright  *
 *    notice, this list of conditions and the following disclaimer in    *
 *    the documentation and/or other materials provided with the         *
 *    distribution.                                                      *
 *                                                                       *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   *
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     *
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS     *
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE        *
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,            *
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES    *
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)    *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,   *
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)         *
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED   *
 * OF THE POSSIBILITY OF SUCH DAMAGE.                                    *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 *  Definition of the \Lousson\URI\Generic\GenericURIScheme class
 *
 *  @package    org.lousson.uri
 *  @copyright  (c) 2012 - 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\URI\Generic;

/** Dependencies: */
use Lousson\URI\AbstractURIScheme;
use Lousson\URI\Builtin\BuiltinURIUtil;

/**
 *  A generic URI scheme implementation
 *
 *  The \Lousson\URI\Generic\GenericURIScheme class is an implementation of
 *  the \Lousson\URI\AnyURIScheme. Any scheme with a well-formed mnemonic
 *  can be represented by this class, although the instance won't be aware
 *  of any constraints associated with the scheme specification, if any.
 *
 *  @since      lousson/uri-0.1.0
 *  @package    org.lousson.uri
 */
class GenericURIScheme extends AbstractURIScheme
{
    /**
     *  Obtain a scheme intstance
     *
     *  The getInstance() method is used to obtain a generic URI scheme
     *  instance for the given $name, which must be a string starting
     *  with a latin character, followed by any number of latin characters,
     *  digits, plus signs (+), minus signs (-) and/or dots.
     *
     *  @param  string  $name
     *
     *  @throws InvalidArgumentException
     *          Raised in case the given $name does not fulfill the
     *          aforementioned constraints
     */
    public static function create($name)
    {
        $util = BuiltinURIUtil::getInstance();
        $util->parseURIScheme($name);
        $scheme = new static($name);
        return $scheme;
    }

    /**
     *  Obtain the scheme's name
     *
     *  The getName() method will return the name of the URI scheme the
     *  object represents. Depending on the requested $type, this is one
     *  of the following phenotypes:
     *
     *- AnyURIScheme::NAME_TYPE_MNEMONIC
     *  Returns the scheme's mnemonic that is used as prefix for URIs
     *  (exluding the colon), e.g. "urn" or "http"
     *
     *- AnyURIScheme::NAME_TYPE_ABBREVIATION
     *  Returns the official abbreviation, if any. Otherwise just returns
     *  an upper-case representation of NAME_TYPE_MNEMONIC, e.g. "HTTP"
     *
     *- AnyURIScheme::NAME_TYPE_ENGLISH
     *  Returns the scheme's full English name. In case of HTTP, for
     *  example, this would be "Hypertext Transfer Protocol"
     *
     *  In case the requested $type is none of the ones above, getName()
     *  will behave as if AnyURIScheme::NAME_TYPE_ABBREVIATION would have
     *  been requested.
     *
     *  @param  int         $type       The type of the name requested
     *
     *  @return string
     *          The name of the URI scheme is returned on success
     */
    final public function getName($type = self::NAME_TYPE_MNEMONIC)
    {
        $name = isset($this->names[$type])
            ? $this->names[$type]
            : $this->names[self::NAME_TYPE_ABBREVIATION];

        return $name;
    }

    /**
     *  Constructor
     *
     *  The constructor has been declared private and is invoked from
     *  within getInstance() exclusively. It transferts the scheme name to
     *  the instance's internals.
     *
     *  @param  string  $name
     */
    final private function __construct($name)
    {
        $this->names[self::NAME_TYPE_MNEMONIC] = strtolower($name);
        $this->names[self::NAME_TYPE_ABBREVIATION] = strtoupper($name);
    }

    /**
     *  A set of names for getName()
     *
     *  @var array
     */
    private $names;
}

